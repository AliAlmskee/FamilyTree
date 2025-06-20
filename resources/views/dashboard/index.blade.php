@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Family Tree Dashboard</h1>
        <p class="text-lg text-gray-600">Welcome to your family tree management system</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Members</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_members'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-male text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Male Members</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['male_members'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 card-hover">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-pink-100 text-pink-600">
                    <i class="fas fa-female text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Female Members</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['female_members'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="{{ route('family-tree.index') }}" class="bg-white rounded-lg shadow-md p-6 card-hover text-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mx-auto w-16 h-16 flex items-center justify-center mb-4">
                <i class="fas fa-users text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">View All Members</h3>
            <p class="text-gray-600">Browse and manage family members</p>
        </a>

        <a href="{{ route('search.index') }}" class="bg-white rounded-lg shadow-md p-6 card-hover text-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mx-auto w-16 h-16 flex items-center justify-center mb-4">
                <i class="fas fa-search text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Search Family</h3>
            <p class="text-gray-600">Find specific family members</p>
        </a>

        <a href="{{ route('import.index') }}" class="bg-white rounded-lg shadow-md p-6 card-hover text-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mx-auto w-16 h-16 flex items-center justify-center mb-4">
                <i class="fas fa-upload text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Import Data</h3>
            <p class="text-gray-600">Upload Excel files with family data</p>
        </a>

        <div class="bg-white rounded-lg shadow-md p-6 card-hover text-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mx-auto w-16 h-16 flex items-center justify-center mb-4">
                <i class="fas fa-chart-line text-2xl"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Analytics</h3>
            <p class="text-gray-600">View family tree statistics</p>
        </div>
    </div>

    <!-- Recent Members -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">Recent Family Members</h2>
        </div>
        <div class="p-6">
            @if($stats['recent_members']->count() > 0)
                <div class="space-y-4">
                    @foreach($stats['recent_members'] as $member)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($member->first_name, 0, 1)) }}
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        {{ $member->first_name }} {{ $member->last_name }}
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        <i class="fas fa-{{ $member->gender === 'male' ? 'male' : 'female' }} mr-1"></i>
                                        {{ ucfirst($member->gender) }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('family-tree.show', $member->id) }}" 
                               class="text-blue-600 hover:text-blue-800 font-medium">
                                View Details
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">No family members found. Start by importing data or adding members manually.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 