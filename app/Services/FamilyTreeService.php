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
     * Get all descendants (children, grandchildren, etc.)
     */
    public function getDescendants(int $memberId): Collection
    {
        $member = FamilyMember::with('children')->find($memberId);
        $descendants = collect();
        
        $this->getDescendantsRecursive($member, $descendants);
        
        return $descendants;
    }

    /**
     * Recursive helper for descendants
     */
    private function getDescendantsRecursive(FamilyMember $member, Collection &$descendants): void
    {
        foreach ($member->children as $child) {
            $descendants->push($child);
            $this->getDescendantsRecursive($child, $descendants);
        }
    }

}