@extends('layouts.app')

@section('title', 'أبناء ' . $member->first_name)

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">أبناء {{ $member->first_name }} {{ $member->last_name }}</h1>
            <p class="text-lg text-gray-600 mt-1">استكشف الأجيال التي تلت {{ $member->first_name }}</p>
        </div>
        <div class="flex space-x-2">
            <a href="{{ route('family-tree.show', $member->id) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-user ml-2"></i>
                الملف الشخصي
            </a>
            <a href="{{ route('family-tree.ancestry', $member->id) }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-up ml-2"></i>
                الأسلاف
            </a>
        </div>
    </div>

    <!-- Descendants Tree -->
    <div class="bg-white rounded-lg shadow-xl p-8">
        @if (empty($descendants))
            <div class="text-center py-12">
                <i class="fas fa-users-slash text-5xl text-gray-400 mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-700">لا يوجد أبناء</h2>
                <p class="text-gray-500 mt-2">لا يوجد أبناء مسجلون لـ {{ $member->first_name }}.</p>
            </div>
        @else
            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-800">شجرة الأبناء</h2>
                <p class="text-gray-600">من الأقدم إلى الأحدث</p>
            </div>
            
            <div class="space-y-8">
                <!-- Root Member -->
                <div class="flex justify-center">
                    <div class="p-4 bg-purple-100 border border-purple-300 rounded-lg shadow-md inline-flex items-center space-x-4">
                        <i class="fas fa-user-circle text-2xl text-purple-700"></i>
                        <a href="{{ route('family-tree.show', $member->id) }}" class="font-bold text-xl text-purple-800 hover:text-purple-600">
                            {{ $member->first_name }} {{ $member->last_name }}
                        </a>
                    </div>
                </div>

                <!-- Generations -->
                @foreach ($descendants as $generation => $members)
                    <div class="space-y-4">
                        <div class="text-center">
                            <h3 class="text-lg font-semibold text-gray-700">
                                الجيل {{ $generation }}
                                @if($generation == 1)
                                    (الأبناء)
                                @elseif($generation == 2)
                                    (الأحفاد)
                                @elseif($generation == 3)
                                    (أبناء الأحفاد)
                                @else
                                    (الجيل {{ $generation }})
                                @endif
                            </h3>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            @foreach ($members as $descendant)
                                <div class="p-4 bg-blue-100 border border-blue-300 rounded-lg shadow-md hover:shadow-lg transition-shadow">
                                    <div class="flex items-center justify-between mb-2">
                                        <a href="{{ route('family-tree.show', $descendant['id']) }}" 
                                           class="font-bold text-blue-800 hover:text-blue-600 text-lg">
                                            {{ $descendant['first_name'] }} {{ $descendant['last_name'] }}
                                        </a>
                                        <span class="text-xs px-2 py-1 rounded-full 
                                            {{ $descendant['gender'] == 'male' ? 'bg-blue-200 text-blue-800' : 'bg-pink-200 text-pink-800' }}">
                                            {{ $descendant['gender'] == 'male' ? 'ذكر' : 'أنثى' }}
                                        </span>
                                    </div>
                                    
                                    @if(!empty($descendant['children']))
                                        <div class="mt-3 pt-3 border-t border-blue-200">
                                            <p class="text-sm text-gray-600 mb-2">
                                                <i class="fas fa-child ml-1"></i>
                                                {{ count($descendant['children']) }} أبناء
                                            </p>
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($descendant['children']->take(3) as $child)
                                                    <span class="text-xs bg-white px-2 py-1 rounded border">
                                                        {{ $child['first_name'] }}
                                                    </span>
                                                @endforeach
                                                @if($descendant['children']->count() > 3)
                                                    <span class="text-xs bg-white px-2 py-1 rounded border">
                                                        +{{ $descendant['children']->count() - 3 }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    @if(!$loop->last)
                        <div class="flex justify-center">
                            <i class="fas fa-arrow-down text-2xl text-gray-400"></i>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection 