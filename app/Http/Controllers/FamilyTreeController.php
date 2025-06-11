<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FamilyTreeBuilder;
use App\Models\FamilyMember;
use Maatwebsite\Excel\Facades\Excel;

class FamilyTreeController extends Controller
{
    protected $treeBuilder;

    public function __construct(FamilyTreeBuilder $treeBuilder)
    {
        $this->treeBuilder = $treeBuilder;
    }

    public function getFamilyMember($id)
    {
        $member = FamilyMember::with(['father', 'mother', 'spouse', 'children'])
                        ->findOrFail($id);

        return response()->json($member);
    }

    

 
}