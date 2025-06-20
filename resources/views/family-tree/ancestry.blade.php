@extends('layouts.app')

@section('title', $member->first_name . ' ' . $member->last_name . ' - Ancestry')

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
                    <a href="{{ route('family-tree.show', $member->id) }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">
                        {{ $member->first_name }} {{ $member->last_name }}
                    </a>
                </div>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">Ancestry</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Ancestry of {{ $member->first_name }} {{ $member->last_name }}</h1>
                <p class="text-gray-600 mt-1">Explore the family tree going back through generations</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('family-tree.show', $member->id) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-user mr-2"></i>
                    Profile
                </a>
                <a href="{{ route('family-tree.descendants', $member->id) }}" 
                   class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-arrow-down mr-2"></i>
                    Descendants
                </a>
            </div>
        </div>
    </div>

    <!-- Ancestry Tree -->
    <div class="bg-white rounded-lg shadow-md p-6">
        @if(is_array($ancestry) && !empty($ancestry))
            <div class="space-y-8">
                @foreach($ancestry as $generation => $members)
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-layer-group mr-2 text-green-600"></i>
                            Generation {{ $generation }}
                            <span class="ml-2 text-sm text-gray-500">({{ $members->count() }} ancestors)</span>
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($members as $ancestor)
                                <div class="bg-gradient-to-br from-green-50 to-blue-50 rounded-lg p-4 border border-green-200 hover:shadow-md transition-shadow">
                                    <div class="flex items-center mb-3">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-green-400 to-blue-500 flex items-center justify-center text-white font-semibold mr-3">
                                            {{ strtoupper(substr($ancestor->first_name, 0, 1)) }}
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-medium text-gray-900">
                                                <a href="{{ route('family-tree.show', $ancestor->id) }}" 
                                                   class="hover:text-blue-600">
                                                    {{ $ancestor->first_name }} {{ $ancestor->last_name }}
                                                </a>
                                            </h3>
                                            @if($ancestor->maiden_name)
                                                <p class="text-sm text-gray-600">({{ $ancestor->maiden_name }})</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <div class="flex items-center text-sm">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $ancestor->gender === 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                                <i class="fas fa-{{ $ancestor->gender === 'male' ? 'male' : 'female' }} mr-1"></i>
                                                {{ ucfirst($ancestor->gender) }}
                                            </span>
                                        </div>
                                        
                                        @if($ancestor->birth_date)
                                            <div class="text-sm text-gray-600">
                                                <i class="fas fa-birthday-cake mr-1"></i>
                                                {{ \Carbon\Carbon::parse($ancestor->birth_date)->format('M j, Y') }}
                                            </div>
                                        @endif
                                        
                                        @if($ancestor->death_date)
                                            <div class="text-sm text-gray-600">
                                                <i class="fas fa-cross mr-1"></i>
                                                {{ \Carbon\Carbon::parse($ancestor->death_date)->format('M j, Y') }}
                                            </div>
                                        @endif
                                        
                                        @if($ancestor->birth_place)
                                            <div class="text-sm text-gray-600">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                {{ $ancestor->birth_place }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Relationship Path -->
                                    <div class="mt-3 pt-3 border-t border-green-200">
                                        <div class="text-xs text-gray-500">
                                            @php
                                                $path = [];
                                                $current = $ancestor;
                                                while($current && $current->id != $member->id) {
                                                    $path[] = $current->first_name;
                                                    if($current->father && $current->father->id != $member->id) {
                                                        $current = $current->father;
                                                    } elseif($current->mother && $current->mother->id != $member->id) {
                                                        $current = $current->mother;
                                                    } else {
                                                        break;
                                                    }
                                                }
                                                $path = array_reverse($path);
                                            @endphp
                                            <i class="fas fa-route mr-1"></i>
                                            {{ implode(' → ', $path) }} → {{ $member->first_name }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-tree text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No ancestry information available</h3>
                <p class="text-gray-500 mb-6">We couldn't find any ancestors for {{ $member->first_name }} {{ $member->last_name }}.</p>
                <a href="{{ route('family-tree.show', $member->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Profile
                </a>
            </div>
        @endif
    </div>

    {{-- <!-- Ancestry Statistics -->
    @if(is_array($ancestry) && !empty($ancestry))
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-chart-bar mr-2 text-blue-600"></i>
                Ancestry Statistics
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="text-3xl font-bold text-blue-600">{{ count($ancestry) }}</div>
                    <div class="text-sm text-gray-600">Generations</div>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-3xl font-bold text-green-600">
                        {{ collect($ancestry)->flatten()->count() }}
                    </div>
                    <div class="text-sm text-gray-600">Total Ancestors</div>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <div class="text-3xl font-bold text-purple-600">
                        {{ collect($ancestry)->flatten()->where('gender', 'male')->count() }}
                    </div>
                    <div class="text-sm text-gray-600">Male Ancestors</div>
                </div>
            </div>
        </div>
    @endif --}}
</div>

@push('scripts')
<script>
    // Add any interactive features here if needed
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    });
</script>
@endpush
@endsection 