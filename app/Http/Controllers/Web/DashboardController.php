<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\FamilyMember;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_members' => FamilyMember::count(),
            'male_members' => FamilyMember::where('gender', 'male')->count(),
            'female_members' => FamilyMember::where('gender', 'female')->count(),
            'recent_members' => FamilyMember::latest()->take(5)->get(),
        ];

        return view('dashboard', compact('stats'));
    }

    public function getFamilyStats()
    {
        // Calculate total members
        $totalMembers = FamilyMember::count();
        
        // Calculate alive members
        $aliveMembers = FamilyMember::where('is_alive', true)->count();
        
        // Calculate generations (this is a simplified calculation)
        $generations = $this->calculateGenerations();
        
        return response()->json([
            'total_members' => $totalMembers,
            'alive_members' => $aliveMembers,
            'generations' => $generations,
        ]);
    }

    private function calculateGenerations()
    {
        // Find the oldest generation (members without parents)
        $rootMembers = FamilyMember::whereNull('father_id')
                                  ->whereNull('mother_id')
                                  ->get();
        
        if ($rootMembers->isEmpty()) {
            return 1; // At least one generation
        }

        $maxGenerations = 1;
        
        foreach ($rootMembers as $rootMember) {
            $generations = $this->countGenerationsFromMember($rootMember);
            $maxGenerations = max($maxGenerations, $generations);
        }
        
        return $maxGenerations;
    }

    private function countGenerationsFromMember($member, $currentGeneration = 1)
    {
        // Get children of this member
        $children = FamilyMember::where('father_id', $member->id)
                               ->orWhere('mother_id', $member->id)
                               ->get();
        
        if ($children->isEmpty()) {
            return $currentGeneration;
        }
        
        $maxChildGenerations = $currentGeneration;
        foreach ($children as $child) {
            $childGenerations = $this->countGenerationsFromMember($child, $currentGeneration + 1);
            $maxChildGenerations = max($maxChildGenerations, $childGenerations);
        }
        
        return $maxChildGenerations;
    }
} 