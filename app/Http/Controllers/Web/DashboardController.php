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
} 