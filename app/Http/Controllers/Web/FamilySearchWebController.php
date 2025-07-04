<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\FamilyTreeService;
use Illuminate\Http\Request;

class FamilySearchWebController extends Controller
{
    protected $searchService;

    public function __construct(FamilyTreeService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function index()
    {
        return view('search.index');
    }

    public function searchByName(Request $request)
    {
        $name = $request->input('name');
        $results = $this->searchService->searchByName($name);
        
        return view('search.results', compact('results', 'name'));
    }

    public function searchByFatherAndChild(Request $request)
    {
        $childName = $request->input('child_name');
        $fatherName = $request->input('father_name');
        
        $results = $this->searchService->searchByFatherAndChild($childName, $fatherName);
        
        $name = "الابن: {$childName}, الأب: {$fatherName}";

        return view('search.results', compact('results', 'name'));
    }
} 