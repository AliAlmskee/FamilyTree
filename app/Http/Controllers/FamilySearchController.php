<?php

namespace App\Http\Controllers;

use App\Services\FamilyTreeService;
use Illuminate\Http\Request;

class FamilySearchController extends Controller
{
    protected $searchService;

    public function __construct(FamilyTreeService $searchService)
    {
        $this->searchService = $searchService;
    }

    public function searchByName(Request $request)
    {
        $name = $request->input('name');
        $results = $this->searchService->searchByName($name);
        
        return response()->json($results);
    }

    public function searchByFatherAndChild(Request $request)
    {
        $childName = $request->input('child_name');
        $fatherName = $request->input('father_name');
        
        $results = $this->searchService->searchByFatherAndChild($childName, $fatherName);
        
        return response()->json($results);
    }

    public function getAncestry($id)
    {
        $results = $this->searchService->getAncestry($id);
        
        return response()->json($results);
    }

    public function getDescendants($id)
    {
        $results = $this->searchService->getDescendants($id);
        
        return response()->json($results);
    }
}