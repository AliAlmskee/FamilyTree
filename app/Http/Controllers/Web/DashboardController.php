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
        // Get total counts with exclusions in one query
        $stats = FamilyMember::selectRaw("
            COUNT(id) as total_members,
            COUNT(CASE WHEN gender = 'female' AND spouse_id IS NOT NULL THEN 1 END) as excluded_total,
            COUNT(CASE WHEN is_alive = 1 THEN 1 END) as alive_members,
            COUNT(CASE WHEN is_alive = 1 AND gender = 'female' AND spouse_id IS NOT NULL THEN 1 END) as excluded_alive
        ")->first();
    
        $adjustedTotal = $stats->total_members - $stats->excluded_total;
        $adjustedAlive = $stats->alive_members - $stats->excluded_alive;
    
        // Calculate generations (assuming you have this method)
        $generations = $this->calculateGenerations();
    
        return response()->json([
            'total_members' => $adjustedTotal,
            'alive_members' => $adjustedAlive,
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