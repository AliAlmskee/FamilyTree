<?php

namespace App\Services;

use App\Models\FamilyMember;
use Illuminate\Support\Collection;

class FamilyTreeService
{
    public function searchByName(string $name)
    {
        return FamilyMember::nameLike($name)->get();
    }

    public function searchByFatherAndChild(string $childName, string $fatherName)
    {
        return FamilyMember::nameLike($childName)
            ->withFatherName($fatherName)
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
     * Get all descendants (children, grandchildren, etc.) organized by generation
     */
    public function getDescendants(int $memberId): array
    {
        $member = FamilyMember::with('children')->find($memberId);
        if (!$member) {
            return [];
        }

        $descendants = [];
        $generation = 1;
        
        // Get children (first generation)
        if ($member->children->isNotEmpty()) {
            $descendants[$generation] = $member->children;
            $generation++;
        }

        // Get grandchildren (second generation)
        $grandchildren = collect();
        foreach ($member->children as $child) {
            $child->load('children');
            foreach ($child->children as $grandchild) {
                $grandchildren->push($grandchild);
            }
        }
        
        if ($grandchildren->isNotEmpty()) {
            $descendants[$generation] = $grandchildren;
            $generation++;
        }

        // Get great-grandchildren (third generation)
        $greatGrandchildren = collect();
        foreach ($grandchildren as $grandchild) {
            $grandchild->load('children');
            foreach ($grandchild->children as $greatGrandchild) {
                $greatGrandchildren->push($greatGrandchild);
            }
        }
        
        if ($greatGrandchildren->isNotEmpty()) {
            $descendants[$generation] = $greatGrandchildren;
        }

        return $descendants;
    }
}