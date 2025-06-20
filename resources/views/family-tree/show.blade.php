@extends('layouts.app')

@section('title', $member->first_name . ' ' . $member->last_name)

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('family-tree.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <i class="fas fa-home mr-2"></i>
                    Family Members
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">{{ $member->first_name }} {{ $member->last_name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Member Profile Header -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-start justify-between">
            <div class="flex items-center space-x-6">
                <div class="w-24 h-24 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center text-white text-3xl font-bold">
                    {{ strtoupper(substr($member->first_name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $member->first_name }} {{ $member->last_name }}</h1>
                    @if($member->maiden_name)
                        <p class="text-lg text-gray-600">({{ $member->maiden_name }})</p>
                    @endif
                    <div class="flex items-center mt-2 space-x-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $member->gender === 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                            <i class="fas fa-{{ $member->gender === 'male' ? 'male' : 'female' }} mr-1"></i>
                            {{ ucfirst($member->gender) }}
                        </span>
                        @if($member->birth_date)
                            <span class="text-gray-600">
                                <i class="fas fa-birthday-cake mr-1"></i>
                                {{ \Carbon\Carbon::parse($member->birth_date)->format('F j, Y') }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('family-tree.ancestry', $member->id) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-arrow-up mr-2"></i>
                    Ancestry
                </a>
                <a href="{{ route('family-tree.descendants', $member->id) }}" 
                   class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-arrow-down mr-2"></i>
                    Descendants
                </a>
            </div>
        </div>
    </div>

    <!-- Family Relationships -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Parents -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-users mr-2 text-blue-600"></i>
                Parents
            </h2>
            <div class="space-y-4">
                @if($member->father)
                    <div class="flex items-center p-4 bg-blue-50 rounded-lg">
                        <div class="w-12 h-12 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold mr-4">
                            {{ strtoupper(substr($member->father->first_name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-900">Father</h3>
                            <a href="{{ route('family-tree.show', $member->father->id) }}" 
                               class="text-blue-600 hover:text-blue-800">
                                {{ $member->father->first_name }} {{ $member->father->last_name }}
                            </a>
                        </div>
                    </div>
                @endif
                @if($member->mother)
                    <div class="flex items-center p-4 bg-pink-50 rounded-lg">
                        <div class="w-12 h-12 rounded-full bg-pink-500 flex items-center justify-center text-white font-semibold mr-4">
                            {{ strtoupper(substr($member->mother->first_name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-900">Mother</h3>
                            <a href="{{ route('family-tree.show', $member->mother->id) }}" 
                               class="text-blue-600 hover:text-blue-800">
                                {{ $member->mother->first_name }} {{ $member->mother->last_name }}
                            </a>
                        </div>
                    </div>
                @endif
                @if(!$member->father && !$member->mother)
                    <p class="text-gray-500 text-center py-4">No parent information available</p>
                @endif
            </div>
        </div>

        <!-- Spouse -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-heart mr-2 text-red-600"></i>
                Spouse
            </h2>
            @if($member->spouse)
                <div class="flex items-center p-4 bg-red-50 rounded-lg">
                    <div class="w-12 h-12 rounded-full bg-red-500 flex items-center justify-center text-white font-semibold mr-4">
                        {{ strtoupper(substr($member->spouse->first_name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900">Spouse</h3>
                        <a href="{{ route('family-tree.show', $member->spouse->id) }}" 
                           class="text-blue-600 hover:text-blue-800">
                            {{ $member->spouse->first_name }} {{ $member->spouse->last_name }}
                        </a>
                    </div>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">No spouse information available</p>
            @endif
        </div>
    </div>

    <!-- Children -->
    @if($member->children->count() > 0)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-baby mr-2 text-green-600"></i>
                Children ({{ $member->children->count() }})
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($member->children as $child)
                    <div class="flex items-center p-4 bg-green-50 rounded-lg">
                        <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white font-semibold mr-3">
                            {{ strtoupper(substr($child->first_name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <a href="{{ route('family-tree.show', $child->id) }}" 
                               class="font-medium text-gray-900 hover:text-blue-600">
                                {{ $child->first_name }} {{ $child->last_name }}
                            </a>
                            <div class="text-sm text-gray-500">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $child->gender === 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    <i class="fas fa-{{ $child->gender === 'male' ? 'male' : 'female' }} mr-1"></i>
                                    {{ ucfirst($child->gender) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Additional Information -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
            <i class="fas fa-info-circle mr-2 text-gray-600"></i>
            Additional Information
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-medium text-gray-900 mb-2">Personal Details</h3>
                <dl class="space-y-2">
                    @if($member->birth_date)
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Birth Date:</dt>
                            <dd class="text-gray-900">{{ \Carbon\Carbon::parse($member->birth_date)->format('F j, Y') }}</dd>
                        </div>
                    @endif
                    @if($member->death_date)
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Death Date:</dt>
                            <dd class="text-gray-900">{{ \Carbon\Carbon::parse($member->death_date)->format('F j, Y') }}</dd>
                        </div>
                    @endif
                    @if($member->birth_place)
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Birth Place:</dt>
                            <dd class="text-gray-900">{{ $member->birth_place }}</dd>
                        </div>
                    @endif
                </dl>
            </div>
            <div>
                <h3 class="font-medium text-gray-900 mb-2">Family Statistics</h3>
                <dl class="space-y-2">
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Children:</dt>
                        <dd class="text-gray-900">{{ $member->children->count() }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Has Spouse:</dt>
                        <dd class="text-gray-900">{{ $member->spouse ? 'Yes' : 'No' }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-600">Has Parents:</dt>
                        <dd class="text-gray-900">{{ ($member->father || $member->mother) ? 'Yes' : 'No' }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection 