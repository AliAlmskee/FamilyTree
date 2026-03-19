@extends('layouts.app')

@section('title', $member->first_name . ' ' . $member->last_name)

@section('content')
<div class="space-y-8">
    <!-- Breadcrumbs -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('family-tree.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <i class="fas fa-users ml-2"></i>
                    أفراد العائلة
                </a>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <i class="fas fa-chevron-left text-gray-400 mx-2"></i>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $member->first_name }} {{ $member->last_name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Member Profile -->
    <div class="bg-white rounded-lg shadow-2xl overflow-hidden">
        <!-- Profile Header -->
        <div class="h-48 bg-gradient-to-r from-blue-400 to-purple-500 relative">
            <div class="absolute bottom-0 right-8 transform translate-y-1/2">
                <div class="h-32 w-32 rounded-full bg-white border-4 border-white shadow-lg flex items-center justify-center text-5xl font-bold text-gray-700">
                    {{ strtoupper(substr($member->first_name, 0, 1)) }}
                </div>
            </div>
        </div>

        <!-- Profile Body -->
        <div class="pt-20 pb-8 px-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-4xl font-bold text-gray-900 flex flex-wrap items-center gap-2">
                        <span>{{ $member->first_name }} {{ $member->last_name }}</span>
                        @foreach($member->countries as $country)
                            @if($country->flag_path)
                                <img src="{{ $country->flag_url }}" alt="{{ $country->name }}" title="{{ $country->name }}" class="h-8 w-auto rounded shadow-sm border border-gray-200 inline-block align-middle">
                            @endif
                        @endforeach
                    </h1>
                    @if($member->maiden_name)
                        <p class="text-xl text-gray-500 mt-1">({{ $member->maiden_name }})</p>
                    @endif
                </div>
                <div class="flex space-x-2">
                    <a href="{{ route('family-tree.ancestry', $member->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-arrow-up ml-2"></i>
                        الأصول
                    </a>
                    <a href="{{ route('family-tree.descendants', $member->id) }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg flex items-center">
                        <i class="fas fa-arrow-down ml-2"></i>
                        الفروع
                    </a>
                </div>
            </div>

            <!-- Details Section -->
            <div class="mt-8 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">التفاصيل الشخصية</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Basic Info -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <i class="fas fa-venus-mars text-gray-500 w-6"></i>
                            <span class="text-gray-700 mr-3 font-semibold">الجنس:</span>
                            <span class="px-3 py-1 text-sm rounded-full {{ $member->gender === 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                {{ $member->gender === 'male' ? 'ذكر' : 'أنثى' }}
                            </span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-birthday-cake text-gray-500 w-6"></i>
                            <span class="text-gray-700 mr-3 font-semibold">تاريخ الميلاد:</span>
                            <span class="text-gray-800">{{ $member->parsed_birth_date?->format('Y') ?? 'غير معروف' }}</span>
                        </div>
                    </div>
                    <!-- Life Status -->
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <i class="fas fa-heartbeat text-gray-500 w-6"></i>
                            <span class="text-gray-700 mr-3 font-semibold">الحالة:</span>
                            <span class="text-gray-800">{{ $member->is_alive ? 'على قيد الحياة' : 'متوفى' }}</span>
                        </div>
                        @if(!$member->is_alive)
                        <div class="flex items-center">
                            <i class="fas fa-calendar-times text-gray-500 w-6"></i>
                            <span class="text-gray-700 mr-3 font-semibold">تاريخ الوفاة:</span>
                            <span class="text-gray-800">{{ $member->parsed_death_date?->format('Y') ?? 'غير معروف' }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Family Section -->
            <div class="mt-12 border-t border-gray-200 pt-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">العائلة</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Parents -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">الوالدين</h3>
                        @if($member->father)
                        <div class="flex items-center">
                            <i class="fas fa-male text-blue-600 w-6"></i>
                            <span class="text-gray-700 mr-3 font-semibold">الأب:</span>
                            <a href="{{ route('family-tree.show', $member->father->id) }}" class="text-blue-600 hover:underline">{{ $member->father->first_name }} {{ $member->father->last_name }}</a>
                        </div>
                        @endif
                        @if($member->mother)
                        <div class="flex items-center">
                            <i class="fas fa-female text-pink-600 w-6"></i>
                            <span class="text-gray-700 mr-3 font-semibold">الأم:</span>
                            <a href="{{ route('family-tree.show', $member->mother->id) }}" class="text-blue-600 hover:underline">{{ $member->mother->first_name }} {{ $member->mother->last_name }}</a>
                        </div>
                        @endif
                        @if(!$member->father && !$member->mother)
                            <p class="text-gray-500">لا توجد معلومات عن الوالدين.</p>
                        @endif
                    </div>

                    <!-- Spouse & Children -->
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">الزوج/الزوجة والأبناء</h3>
                        @if($member->spouse)
                        <div class="flex items-center">
                            <i class="fas fa-heart text-red-600 w-6"></i>
                            <span class="text-gray-700 mr-3 font-semibold">الزوج/الزوجة:</span>
                            <a href="{{ route('family-tree.show', $member->spouse->id) }}" class="text-blue-600 hover:underline">{{ $member->spouse->first_name }} {{ $member->spouse->last_name }}</a>
                        </div>
                        @endif
                        @if($member->all_children->count() > 0)
                            <div class="flex items-start">
                                <i class="fas fa-baby text-green-600 w-6 mt-1"></i>
                                <span class="text-gray-700 mr-3 font-semibold">الأبناء:</span>
                                <div>
                                    @foreach($member->all_children as $child)
                                        <a href="{{ route('family-tree.show', $child->id) }}" class="text-blue-600 hover:underline block">{{ $child->first_name }} {{ $child->last_name }}</a>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        @if(!$member->spouse && $member->all_children->count() == 0)
                            <p class="text-gray-500">لا توجد معلومات عن الزوج/الزوجة أو الأبناء.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 