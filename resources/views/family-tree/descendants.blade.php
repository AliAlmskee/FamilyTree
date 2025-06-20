@extends('layouts.app')

@section('title', $member->first_name . ' ' . $member->last_name . ' - Descendants')

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
                    <span class="text-sm font-medium text-gray-500">Descendants</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Descendants of {{ $member->first_name }} {{ $member->last_name }}</h1>
                <p class="text-gray-600 mt-1">Explore the family tree going forward through generations</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('family-tree.show', $member->id) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-user mr-2"></i>
                    Profile
                </a>
                <a href="{{ route('family-tree.ancestry', $member->id) }}" 
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-arrow-up mr-2"></i>
                    Ancestry
                </a>
            </div>
        </div>
    </div>

    <!-- Descendants Tree -->
    <div class="bg-white rounded-lg shadow-md p-6">
        @if(is_array($descendants) && !empty($descendants))
            <div class="space-y-8">
                @foreach($descendants as $generation => $members)
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-layer-group mr-2 text-purple-600"></i>
                            Generation {{ $generation }}
                            <span class="ml-2 text-sm text-gray-500">({{ $members->count() }} descendants)</span>
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            @foreach($members as $descendant)
                                <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg p-4 border border-purple-200 hover:shadow-md transition-shadow">
                                    <div class="flex items-center mb-3">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-purple-400 to-pink-500 flex items-center justify-center text-white font-semibold mr-3">
                                            {{ strtoupper(substr($descendant->first_name, 0, 1)) }}
                                        </div>
                                        <div class="flex-1">
                                            <h3 class="font-medium text-gray-900">
                                                <a href="{{ route('family-tree.show', $descendant->id) }}" 
                                                   class="hover:text-purple-600">
                                                    {{ $descendant->first_name }} {{ $descendant->last_name }}
                                                </a>
                                            </h3>
                                            @if($descendant->maiden_name)
                                                <p class="text-sm text-gray-600">({{ $descendant->maiden_name }})</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <div class="flex items-center text-sm">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $descendant->gender === 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                                <i class="fas fa-{{ $descendant->gender === 'male' ? 'male' : 'female' }} mr-1"></i>
                                                {{ ucfirst($descendant->gender) }}
                                            </span>
                                        </div>
                                        
                                        @if($descendant->birth_date)
                                            <div class="text-sm text-gray-600">
                                                <i class="fas fa-birthday-cake mr-1"></i>
                                                {{ \Carbon\Carbon::parse($descendant->birth_date)->format('M j, Y') }}
                                            </div>
                                        @endif
                                        
                                        @if($descendant->death_date)
                                            <div class="text-sm text-gray-600">
                                                <i class="fas fa-cross mr-1"></i>
                                                {{ \Carbon\Carbon::parse($descendant->death_date)->format('M j, Y') }}
                                            </div>
                                        @endif
                                        
                                        @if($descendant->birth_place)
                                            <div class="text-sm text-gray-600">
                                                <i class="fas fa-map-marker-alt mr-1"></i>
                                                {{ $descendant->birth_place }}
                                            </div>
                                        @endif
                                        
                                        @if($descendant->children && $descendant->children->count() > 0)
                                            <div class="text-sm text-gray-600">
                                                <i class="fas fa-baby mr-1"></i>
                                                {{ $descendant->children->count() }} children
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Relationship Path -->
                                    <div class="mt-3 pt-3 border-t border-purple-200">
                                        <div class="text-xs text-gray-500">
                                            @php
                                                $path = [];
                                                $current = $descendant;
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
                                            {{ $member->first_name }} → {{ implode(' → ', $path) }}
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
                <i class="fas fa-baby text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No descendants found</h3>
                <p class="text-gray-500 mb-6">{{ $member->first_name }} {{ $member->last_name }} doesn't have any descendants yet.</p>
                <a href="{{ route('family-tree.show', $member->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Profile
                </a>
            </div>
        @endif
    </div>

    <!-- Descendants Statistics -->
    @if(is_array($descendants) && !empty($descendants))
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-chart-bar mr-2 text-purple-600"></i>
                Descendants Statistics
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <div class="text-3xl font-bold text-purple-600">{{ count($descendants) }}</div>
                    <div class="text-sm text-gray-600">Generations</div>
                </div>
                <div class="text-center p-4 bg-pink-50 rounded-lg">
                    <div class="text-3xl font-bold text-pink-600">
                        {{ collect($descendants)->flatten()->count() }}
                    </div>
                    <div class="text-sm text-gray-600">Total Descendants</div>
                </div>
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="text-3xl font-bold text-blue-600">
                        {{ collect($descendants)->flatten()->where('gender', 'male')->count() }}
                    </div>
                    <div class="text-sm text-gray-600">Male Descendants</div>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-3xl font-bold text-green-600">
                        {{ collect($descendants)->flatten()->where('gender', 'female')->count() }}
                    </div>
                    <div class="text-sm text-gray-600">Female Descendants</div>
                </div>
            </div>
        </div>

        <!-- Family Tree Visualization -->
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-sitemap mr-2 text-indigo-600"></i>
                Family Tree Structure
            </h2>
            <div class="overflow-x-auto">
                <div class="min-w-max">
                    @php
                        $maxGenerations = count($descendants);
                    @endphp
                    <div class="grid grid-cols-{{ $maxGenerations + 1 }} gap-4">
                        <!-- Root Member -->
                        <div class="text-center">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center text-white font-semibold mx-auto mb-2">
                                {{ strtoupper(substr($member->first_name, 0, 1)) }}
                            </div>
                            <div class="text-xs text-gray-600">{{ $member->first_name }}</div>
                            <div class="text-xs text-gray-500">{{ $member->last_name }}</div>
                        </div>
                        
                        <!-- Descendants by Generation -->
                        @foreach($descendants as $generation => $members)
                            <div class="space-y-2">
                                @foreach($members as $descendant)
                                    <div class="text-center">
                                        <div class="w-12 h-12 rounded-full bg-gradient-to-r from-purple-400 to-pink-500 flex items-center justify-center text-white font-semibold mx-auto mb-1">
                                            {{ strtoupper(substr($descendant->first_name, 0, 1)) }}
                                        </div>
                                        <div class="text-xs text-gray-600">{{ $descendant->first_name }}</div>
                                        <div class="text-xs text-gray-500">{{ $descendant->last_name }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add hover effects for descendant cards
        document.querySelectorAll('.hover\\:shadow-md').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endpush
@endsection 