<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FamilyTreeBuilder;
use Maatwebsite\Excel\Facades\Excel;

class FamilyTreeImportController extends Controller
{
    protected $treeBuilder;

    public function __construct(FamilyTreeBuilder $treeBuilder)
    {
        $this->treeBuilder = $treeBuilder;
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|file|mimes:xlsx,xls'
        ]);

        $file = $request->file('excel_file');
        
        try {
            // Read Excel data into array
            $data = Excel::toArray([], $file)[0]; // Gets first sheet as array
            
            // Convert to simple 2D array of values
            $excelData = array_map(function($row) {
                return array_values($row);
            }, $data);

            $root = $this->treeBuilder->buildFromExcelData($excelData);
            
            return response()->json([
                'message' => 'Family tree imported successfully',
                'root_member' => $root,
                'success' => true
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error importing file: ' . $e->getMessage(),
                'success' => false
            ], 500);
        }
    }
}