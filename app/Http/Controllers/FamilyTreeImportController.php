<?php

namespace App\Services;

use App\Models\FamilyMember;

class FamilyTreeBuilder
{
    /**
     * Entry point
     */
    public function buildFromExcelData(array $rows): void
    {
        $childrenIndex = $this->indexByFather($rows);

        foreach ($rows as $row) {

            // Header row = new root object
            if ($this->isHeaderRow($row)) {
                continue;
            }

            // Root person (no father)
            if (empty(trim($row['اسم الاب'] ?? ''))) {
                $this->buildPersonTree($row, $childrenIndex);
            }
        }
    }

    /**
     * Recursive tree builder
     */
    private function buildPersonTree(
        array $row,
        array $childrenIndex,
        ?FamilyMember $father = null
    ): FamilyMember {

        $name   = trim($row['الاسم']);
        $gender = trim($row['الجنس'] ?? '');

        if ($name === '') {
            return null;
        }

        // Create or get person (unique per father)
        $person = FamilyMember::firstOrCreate(
            [
                'first_name' => $name,
                'father_id'  => $father?->id,
            ],
            [
                'gender' => $gender,
            ]
        );

        // Attach father
        if ($father && $person->father_id !== $father->id) {
            $person->father_id = $father->id;
            $person->save();
        }

        // Attach wife (if male)
        if ($gender === 'ذكر' && !empty($row['اسم الزوجة'])) {
            $this->attachWife($person, trim($row['اسم الزوجة']));
        }

        // Recurse children
        foreach ($childrenIndex[$name] ?? [] as $childRow) {

            // Stop recursion if a new header is encountered
            if ($this->isHeaderRow($childRow)) {
                break;
            }

            $this->buildPersonTree($childRow, $childrenIndex, $person);
        }

        return $person;
    }

    /**
     * Index children by father name
     */
    private function indexByFather(array $rows): array
    {
        $map = [];

        foreach ($rows as $row) {
            if ($this->isHeaderRow($row)) {
                break;
            }

            $fatherName = trim($row['اسم الاب'] ?? '');

            if ($fatherName !== '') {
                $map[$fatherName][] = $row;
            }
        }

        return $map;
    }

    /**
     * Detect repeated header rows
     */
    private function isHeaderRow(array $row): bool
    {
        return trim($row['الاسم'] ?? '') === 'الاسم';
    }

    /**
     * Attach wife to husband
     */
    private function attachWife(FamilyMember $husband, string $wifeName): void
    {
        $wife = FamilyMember::firstOrCreate(
            ['first_name' => $wifeName],
            ['gender' => 'أنثى']
        );

        if (method_exists($husband, 'wives')) {
            $husband->wives()->syncWithoutDetaching($wife->id);
        }
    }
}
