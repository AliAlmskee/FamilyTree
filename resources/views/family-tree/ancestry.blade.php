@extends('layouts.app')

@section('title', 'أسلاف ' . $member->first_name)

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">شجرة أسلاف {{ $member->first_name }} {{ $member->last_name }}</h1>
            <p class="text-lg text-gray-600 mt-1">تتبع أصول {{ $member->first_name }} عبر الأجيال</p>
        </div>
        <a href="{{ route('family-tree.show', $member->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
            <i class="fas fa-user ml-2"></i>
            عرض الملف الشخصي
        </a>
    </div>

    <!-- Ancestry Tree -->
    <div class="bg-white rounded-lg shadow-xl p-8">
        @if(empty($ancestry))
            <div class="text-center py-12">
                <i class="fas fa-info-circle text-5xl text-gray-400 mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-700">لا توجد معلومات عن الأسلاف</h2>
                <p class="text-gray-500 mt-2">لا يمكن العثور على والدين لـ {{ $member->first_name }}.</p>
            </div>
        @else
            @php
                $ancestors = [];
                if (!empty($ancestry)) {
                    $current = $ancestry[0];
                    while ($current) {
                        $ancestors[] = $current;
                        $current = $current['father'] ?? null;
                    }
                }
            @endphp

            <div class="text-center mb-12">
                <h2 class="text-2xl font-bold text-gray-800">شجرة نسب {{ $member->first_name }}</h2>
                <p class="text-gray-600">من الأحدث إلى الأقدم</p>
            </div>

            <div class="flex flex-col items-center">
                @foreach ($ancestors as $ancestor)
                    <div class="p-4 bg-blue-100 border border-blue-300 rounded-lg shadow-md inline-flex items-center space-x-4 min-w-[250px] justify-center">
                        <a href="{{ route('family-tree.show', $ancestor['id']) }}" class="font-bold text-xl text-blue-800 hover:text-blue-600">
                            {{ $ancestor['first_name'] }} {{ $ancestor['last_name'] }}
                        </a>
                    </div>

                    @if (!$loop->last)
                        <div class="my-2">
                            <i class="fas fa-arrow-down text-2xl text-gray-400"></i>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection 