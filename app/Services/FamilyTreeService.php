<?php

namespace App\Services;

use App\Models\FamilyMember;
use Illuminate\Support\Collection;

class FamilyTreeService
{
    public function searchByName(string $name)
    {
        return FamilyMember::nameLike(trim($name))->get();
    }

    public function searchByFatherAndChild(string $childName, string $fatherName)
    {
        return FamilyMember::nameLike(trim($childName))
            ->withFatherName(trim($fatherName))
            ->get();
    }

    public function getAncestry(int $memberId): Collection
    {
        $ancestry = collect();
        $current = FamilyMember::find($memberId);
        $visited = true ; 
        while ($current) {
            if ($visited) {
                $ancestry->push($current);
                $visited = false ; 
            }
            $current = $current->father;
        }
        return $ancestry;
    }

    /**
     * Get all descendants (children, grandchildren, etc.) organized by generation.
     * Uses both father_id and mother_id so mothers see their children.
     */
    public function getDescendants(int $memberId): array
    {
        $member = FamilyMember::find($memberId);
        if (!$member) {
            return [];
        }

        $descendants = [];
        $generation = 1;

        // First generation: children (whether member is father or mother)
        $children = $member->allChildren()->orderBy('birth_date')->get();
        if ($children->isNotEmpty()) {
            $descendants[$generation] = $children;
            $generation++;
        }

        // Second generation: grandchildren
        $grandchildren = collect();
        foreach ($children as $child) {
            $childChildren = $child->allChildren()->orderBy('birth_date')->get();
            foreach ($childChildren as $grandchild) {
                $grandchildren->push($grandchild);
            }
        }
        if ($grandchildren->isNotEmpty()) {
            $descendants[$generation] = $grandchildren;
            $generation++;
        }

        // Third generation: great-grandchildren
        $greatGrandchildren = collect();
        foreach ($grandchildren as $grandchild) {
            $greatGrandchildChildren = $grandchild->allChildren()->orderBy('birth_date')->get();
            foreach ($greatGrandchildChildren as $greatGrandchild) {
                $greatGrandchildren->push($greatGrandchild);
            }
        }
        if ($greatGrandchildren->isNotEmpty()) {
            $descendants[$generation] = $greatGrandchildren;
        }

        return $descendants;
    }
}