@extends('layouts.app')

@section('title', 'لوحة التحكم')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-800">مرحباً بك في لوحة تحكم شجرة العائلة</h1>
        <p class="text-xl text-gray-600 mt-2">نظرة عامة على نظام شجرة العائلة الخاص بك</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-lg p-6 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-700">إجمالي الأفراد</h3>
                <p class="text-4xl font-bold text-gray-900">{{ $stats['total_members'] }}</p>
            </div>
            <i class="fas fa-users text-5xl text-blue-500 opacity-50"></i>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-700">الذكور</h3>
                <p class="text-4xl font-bold text-gray-900">{{ $stats['male_count'] }}</p>
            </div>
            <i class="fas fa-male text-5xl text-blue-500 opacity-50"></i>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-700">الإناث</h3>
                <p class="text-4xl font-bold text-gray-900">{{ $stats['female_count'] }}</p>
            </div>
            <i class="fas fa-female text-5xl text-pink-500 opacity-50"></i>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 flex items-center justify-between">
            <div>
                <h3 class="text-lg font-semibold text-gray-700">الأجيال</h3>
                <p class="text-4xl font-bold text-gray-900">{{ $stats['generations'] }}</p>
            </div>
            <i class="fas fa-layer-group text-5xl text-green-500 opacity-50"></i>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">إجراءات سريعة</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
            <a href="{{ route('family-tree.index') }}" class="block p-6 bg-blue-50 hover:bg-blue-100 rounded-lg transition duration-300">
                <i class="fas fa-list text-4xl text-blue-600 mb-4"></i>
                <h3 class="font-semibold text-lg text-gray-800">عرض كل الأفراد</h3>
                <p class="text-gray-600">تصفح القائمة الكاملة للعائلة</p>
            </a>
            <a href="{{ route('search.index') }}" class="block p-6 bg-green-50 hover:bg-green-100 rounded-lg transition duration-300">
                <i class="fas fa-search text-4xl text-green-600 mb-4"></i>
                <h3 class="font-semibold text-lg text-gray-800">بحث</h3>
                <p class="text-gray-600">ابحث عن أفراد محددين</p>
            </a>
            <a href="#" class="block p-6 bg-purple-50 hover:bg-purple-100 rounded-lg transition duration-300">
                <i class="fas fa-plus-circle text-4xl text-purple-600 mb-4"></i>
                <h3 class="font-semibold text-lg text-gray-800">إضافة فرد جديد</h3>
                <p class="text-gray-600">أضف فردًا جديدًا إلى الشجرة</p>
            </a>
        </div>
    </div>

    <!-- Recent Additions -->
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-semibold text-gray-800 mb-6">الإضافات الأخيرة</h2>
        @if($recent_members->count() > 0)
            <ul class="space-y-4">
                @foreach($recent_members as $member)
                    <li class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center bg-gray-200 text-gray-600 font-bold text-xl mr-4">
                                {{ strtoupper(substr($member->first_name, 0, 1)) }}
                            </div>
                            <div>
                                <a href="{{ route('family-tree.show', $member->id) }}" class="font-semibold text-lg text-blue-600 hover:text-blue-800">{{ $member->first_name }} {{ $member->last_name }}</a>
                                <p class="text-gray-500">تمت إضافته في {{ $member->created_at->format('d-m-Y') }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 text-sm rounded-full {{ $member->gender === 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                            {{ $member->gender === 'male' ? 'ذكر' : 'أنثى' }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-center text-gray-500">لم يتم إضافة أي أفراد مؤخراً.</p>
        @endif
    </div>
</div>
@endsection 