<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\FamilyMember;

class FamilyTreeController extends Controller
{
    public function processToMap(Request $request)
    {
        $inputPath = "C:/Users/Ali-Almski/Desktop/input.xls";

        $rows = Excel::toArray([], $inputPath, null, \Maatwebsite\Excel\Excel::XLS)[1];

        $persons = $this->extractBlocks($rows);

        return $this->storeFamilyTree($persons);
    }

    /**
     * Extract persons from Excel rows
     */
    private function extractBlocks(array $rows): array
    {
        $persons = [];
        $currentPerson = null;
        $headerMap = [];

        foreach ($rows as $row) {

            $row = array_map(fn ($v) => trim((string) $v), $row);

            // detect header
            if (in_array('الاسم', $row)) {

                if ($currentPerson) {
                    $persons[] = $currentPerson;
                }

                $headerMap = [];
                foreach ($row as $colIndex => $title) {
                    if ($title !== '') {
                        $headerMap[$colIndex] = $title;
                    }
                }

                $currentPerson = [
                    'id'         => null,
                    'father_id'  => null,
                    'name'       => null,
                    'gender'     => null,
                    'birth_date' => null,
                    'death_date' => null,
                    'wives'      => [],
                    'children'   => [],
                ];

                continue;
            }

            if (!$currentPerson || empty(array_filter($row))) {
                continue;
            }

            $rowValues = [];
            foreach ($headerMap as $colIndex => $field) {
                $rowValues[$field] = $row[$colIndex] ?? null;
            }

            if (!empty($rowValues['id'])) {
                $currentPerson['id'] = (int) $rowValues['id'];
            }

            if (!empty($rowValues['father-id']) && $rowValues['father-id'] != 0) {
                $currentPerson['father_id'] = (int) $rowValues['father-id'];
            }

            if (!empty($rowValues['الاسم'])) {
                $currentPerson['name'] ??= $rowValues['الاسم'];
            }

            if (!empty($rowValues['الجنس']) && empty($rowValues['الأولاد'])) {
                $currentPerson['gender'] ??= $rowValues['الجنس'];
            }

            if (!empty($rowValues['تاريخ الميلاد'])) {
                $currentPerson['birth_date'] ??= $rowValues['تاريخ الميلاد'];
            }

            if (!empty($rowValues['تاريخ الوفاة'])) {
                $currentPerson['death_date'] ??= $rowValues['تاريخ الوفاة'];
            }

            // wives
            if (!empty($rowValues['اسم الزوجه'])) {
                if (!in_array($rowValues['اسم الزوجه'], $currentPerson['wives'])) {
                    $currentPerson['wives'][] = [
                        'name'       => $rowValues['اسم الزوجه'],
                        'birth_date' => $rowValues['تاريخ الميلاد'] ?? null,
                        'death_date' => $rowValues['تاريخ الوفاة'] ?? null,
                    ];
                }
            }

            // children
            if (!empty($rowValues['الأولاد'])) {
                $currentPerson['children'][] = [
                    'name'       => $rowValues['الأولاد'],
                    'gender'     => $rowValues['الجنس'] ?? null,
                    'birth_date' => $rowValues['تاريخ الميلاد'] ?? null,
                    'death_date' => $rowValues['تاريخ الوفاة'] ?? null,
                ];
            }
            if (!empty($rowValues['اسم الام ']) && $rowValues['اسم الام '] != 0) {
                    $currentPerson['mother_name'][] = $rowValues['اسم الام '];
                }
        }

        if ($currentPerson) {
            $persons[] = $currentPerson;
        }

        return $persons;
    }

    /**
     * Store family tree in DB
     */
    private function storeFamilyTree(array $persons)
    {

                $dbMap = [];
                $nameIndex = [];
                $personIndex = [];

                /**
                 * Build lookup of real persons from Excel
                 * key = name + fatherExcelId
                 */
                foreach ($persons as $p) {
                    if ($p['name']) {
                        $key = $p['name'] . '_' . ($p['father_id'] ?? 0);
                        $personIndex[$key] = $p['id'];
                    }
                }

                /**
                 * PASS 1 — create real persons
                 */
                foreach ($persons as $p) {

                    $member = FamilyMember::create([
                        'first_name' => $p['name'],
                        'last_name'  => 'أبو جيب',
                        'gender'     => $p['gender'] === 'أنثى' ? 'female' : 'male',
                        'address'    => null,
                        'is_alive'   => empty($p['death_date']),
                        'father_id'  => null,
                        'mother_id'  => null,
                        'spouse_id'  => null,
                        'birth_date' => $p['birth_date'] ?? null,
                        'death_date' => $p['death_date'] ?? null,
                    ]);

                    $dbMap[$p['id']] = $member->id;
                    $nameIndex[$p['name']] = $member->id;
                }

                /**
                 * PASS 2 — link fathers
                 */
                foreach ($persons as $p) {

                    if (!$p['father_id']) continue;

                    if (!isset($dbMap[$p['id']], $dbMap[$p['father_id']])) continue;

                    FamilyMember::where('id', $dbMap[$p['id']])
                        ->update(['father_id' => $dbMap[$p['father_id']]]);
                }
               
              /** PASS 3 — wives + children */
        foreach ($persons as $p) {

            $fatherDbId = $dbMap[$p['id']] ?? null;
            if (!$fatherDbId) continue;

            // wives
            foreach ($p['wives'] as $wife) {

                if (isset($nameIndex[$wife['name']])) continue;

                $wifeModel = FamilyMember::create([
                    'first_name' => $wife['name'],
                    'last_name'  => ' ',
                    'gender'     => 'female',
                    'father_id'  => null,
                    'mother_id'  => null,
                    'spouse_id'  => $fatherDbId,
                    'address'    => null,
                    'is_alive'   => empty($wife['death_date']),
                    'birth_date' => $wife['birth_date'],
                    'death_date' => $wife['death_date'],
                ]);

                FamilyMember::where('id', $fatherDbId)
                    ->update(['spouse_id' => $wifeModel->id]);

                $nameIndex[$wife['name']] = $wifeModel->id;
            }

            // children
            foreach ($p['children'] as $child) {

                $childName = $child['name'];
                $lookupKey = $childName . '_' . ($p['id'] ?? 0);

                if (isset($personIndex[$lookupKey])) {
                    continue;
                }

                FamilyMember::create([
                    'first_name' => $childName,
                    'last_name'  => 'أبو جيب',
                    'gender'     => ($child['gender'] ?? '') === 'أنثى' ? 'female' : 'male',
                    'father_id'  => $fatherDbId,
                    'mother_id'  => null,
                    'spouse_id'  => null,
                    'address'    => null,
                    'is_alive'   => empty($child['death_date']),
                    'birth_date' => $child['birth_date'],
                    'death_date' => $child['death_date'],
                ]);
            }
        }

             /**
             * PASS 5 — set mother_id based on father's spouse
             */
            $allMembers = FamilyMember::all();

            foreach ($allMembers as $member) {
                if ($member->father_id) {
                    $father = FamilyMember::find($member->father_id);
                    if ($father && $father->spouse_id) {
                        $member->mother_id = $father->spouse_id;
                        $member->save();
                    }
                }
            }
            return response()->json([
                'status'  => 'complete'
            ]);

    }
}