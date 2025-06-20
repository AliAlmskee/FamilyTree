<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\FamilyTreeBuilder;
use App\Services\FamilyTreeService;
use App\Models\FamilyMember;
use Illuminate\Http\Request;

class FamilyTreeWebController extends Controller
{
    protected $treeBuilder;
    protected $searchService;

    public function __construct(FamilyTreeBuilder $treeBuilder, FamilyTreeService $searchService)
    {
        $this->treeBuilder = $treeBuilder;
        $this->searchService = $searchService;
    }

    public function index()
    {
        $members = FamilyMember::with(['father', 'mother', 'spouse'])
                    ->orderBy('first_name')
                    ->paginate(20);

        return view('family-tree.index', compact('members'));
    }

    public function show($id)
    {
        $member = FamilyMember::with(['father', 'mother', 'spouse', 'children'])
                    ->findOrFail($id);

        return view('family-tree.show', compact('member'));
    }

    public function ancestry($id)
    {
        $member = FamilyMember::findOrFail($id);
        $ancestry = $this->searchService->getAncestry($id);

        return view('family-tree.ancestry', compact('member', 'ancestry'));
    }

    public function descendants($id)
    {
        $member = FamilyMember::findOrFail($id);
        $descendants = $this->searchService->getDescendants($id);

        return view('family-tree.descendants', compact('member', 'descendants'));
    }
} 