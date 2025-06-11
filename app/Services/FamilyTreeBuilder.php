<?php

namespace App\Services;

use App\Models\FamilyMember;

class FamilyTreeBuilder
{
    public function buildFromExcelData(array $data)
    {
        if (empty($data)) {
            return null;
        }

        $rootName = $data[0][0] ?? 'Root';
        $root = FamilyMember::firstOrCreate([
            'first_name' => $rootName,
            'last_name' => 'ابو جيب'
        ]);

        $this->processExcelData($data, 0, 0, $root);

        return $root;
    }

    private function processExcelData(array $data, int $i, int $j, FamilyMember $parent)
    {
        if ($i >= count($data) || $j >= (count($data[0]) - 1)) {
            return ;
        }

        $k = $i;
        for (; $k < count($data); $k++) {
            if (!isset($data[$k][$j]) || $data[$k][$j] !== $parent->first_name) {
                break;
            }

            if (isset($data[$k][$j+1]) && $data[$k][$j+1] !== "") {
                $childName = $data[$k][$j+1];
                
                // Check if child already exists under this parent
                $existingChild = $parent->children()
                    ->where('first_name', $childName)
                    ->first();

                if (!$existingChild) {
                    $child = FamilyMember::create([
                        'first_name' => $childName,
                        'last_name' => 'ابو جيب'
                    ]);

                    $child->father_id = $parent->id;
                    $child->save();

                    $this->processExcelData($data, $k, $j+1, $child);
                }
            }
        }

        if ($k < count($data)) {
            $nextParentName = $data[$k][$j] ?? null;
            if ($nextParentName) {
                $nextParent = FamilyMember::where('first_name', $nextParentName)->first();
                if ($nextParent) {
                    $this->processExcelData($data, $i, $j+2, $nextParent);
                }
            }
        }
    }
}