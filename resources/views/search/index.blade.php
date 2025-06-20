@extends('layouts.app')

@section('title', 'Search Family')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-3xl font-bold text-gray-900 mb-4">Search Family Members</h1>
        <p class="text-lg text-gray-600">Find specific family members using different search criteria</p>
    </div>

    <!-- Search Options -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Search by Name -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-user text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Search by Name</h2>
                    <p class="text-gray-600">Find family members by their first name</p>
                </div>
            </div>
            
            <form action="{{ route('search.by-name') }}" method="GET" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                    <input type="text" 
                           id="name"
                           name="name" 
                           placeholder="Enter the first name ..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           required>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center justify-center">
                    <i class="fas fa-search mr-2"></i>
                    Search by Name
                </button>
            </form>
        </div>

        <!-- Search by Father and Child -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center mb-4">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-users text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Search by Father & Child</h2>
                    <p class="text-gray-600">Find family members by father and child relationship</p>
                </div>
            </div>
            
            <form action="{{ route('search.by-father-child') }}" method="GET" class="space-y-4">
                <div>
                    <label for="father_name" class="block text-sm font-medium text-gray-700 mb-2">Father's Name</label>
                    <input type="text" 
                           id="father_name"
                           name="father_name" 
                           placeholder="Enter father's name..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           required>
                </div>
                <div>
                    <label for="child_name" class="block text-sm font-medium text-gray-700 mb-2">Child's Name</label>
                    <input type="text" 
                           id="child_name"
                           name="child_name" 
                           placeholder="Enter child's name..." 
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           required>
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg flex items-center justify-center">
                    <i class="fas fa-search mr-2"></i>
                    Search by Relationship
                </button>
            </form>
        </div>
    </div>

    <!-- Quick Links -->
    {{-- <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('family-tree.index') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-list text-blue-600 mr-3"></i>
                <div>
                    <h3 class="font-medium text-gray-900">View All Members</h3>
                    <p class="text-sm text-gray-600">Browse complete family list</p>
                </div>
            </a>
            
            <a href="{{ route('dashboard') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-home text-purple-600 mr-3"></i>
                <div>
                    <h3 class="font-medium text-gray-900">Dashboard</h3>
                    <p class="text-sm text-gray-600">Return to overview</p>
                </div>
            </a>
        </div>
    </div> --}}

    <!-- Search Tips -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <i class="fas fa-lightbulb text-blue-600 mt-1 mr-3"></i>
            <div>
                <h3 class="text-lg font-medium text-blue-900 mb-2">Search Tips</h3>
                <ul class="text-blue-800 space-y-1">
                    <li>• Use partial names for broader search results</li>
                    <li>• Search is case-insensitive</li>
                    <li>• You can search by first name </li>
                    <li>• For father-child search, both names are required</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 