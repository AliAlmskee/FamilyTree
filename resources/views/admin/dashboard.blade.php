@extends('layouts.app')

@section('title', 'لوحة الإدارة')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">لوحة الإدارة</h1>
        <p class="text-gray-600">مرحباً بك في لوحة إدارة شجرة العائلة</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-users text-2xl"></i>
                </div>
                <div class="mr-4">
                    <p class="text-sm font-medium text-gray-600">إجمالي الأعضاء</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total_members'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-clock text-2xl"></i>
                </div>
                <div class="mr-4">
                    <p class="text-sm font-medium text-gray-600">الأخبار المعلقة</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_news'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-check-circle text-2xl"></i>
                </div>
                <div class="mr-4">
                    <p class="text-sm font-medium text-gray-600">الأخبار المعتمدة</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['approved_news'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Pending News -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">الأخبار المعلقة</h3>
            </div>
            <div class="p-6">
                @if($pendingNews->count() > 0)
                    <div class="space-y-4">
                        @foreach($pendingNews as $news)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $news->title }}</h4>
                                    <p class="text-sm text-gray-600">{{ Str::limit($news->content, 100) }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $news->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex space-x-2 space-x-reverse">
                                    <form action="{{ route('admin.news.approve', $news->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded text-sm hover:bg-green-600">
                                            <i class="fas fa-check ml-1"></i> موافقة
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.news.reject', $news->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded text-sm hover:bg-red-600" onclick="return confirm('هل أنت متأكد من رفض هذا الخبر؟')">
                                            <i class="fas fa-times ml-1"></i> رفض
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.news.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            عرض جميع الأخبار <i class="fas fa-arrow-left ml-1"></i>
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">لا توجد أخبار معلقة</p>
                @endif
            </div>
        </div>

        <!-- Recent Members -->
        <div class="bg-white rounded-lg shadow-md">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">الأعضاء الجدد</h3>
            </div>
            <div class="p-6">
                @if($recentMembers->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentMembers as $member)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex-1">
                                    <h4 class="font-medium text-gray-900">{{ $member->first_name }} {{ $member->last_name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $member->gender === 'male' ? 'ذكر' : 'أنثى' }}</p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $member->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="flex space-x-2 space-x-reverse">
                                    <a href="{{ route('admin.members.edit', $member->id) }}" class="bg-blue-500 text-white px-3 py-1 rounded text-sm hover:bg-blue-600">
                                        <i class="fas fa-edit ml-1"></i> تعديل
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.members.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            عرض جميع الأعضاء <i class="fas fa-arrow-left ml-1"></i>
                        </a>
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">لا توجد أعضاء جدد</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">روابط سريعة</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.news.index') }}" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                <i class="fas fa-newspaper text-blue-600 text-xl ml-3"></i>
                <div>
                    <h4 class="font-medium text-gray-900">إدارة الأخبار</h4>
                    <p class="text-sm text-gray-600">عرض وتعديل الأخبار</p>
                </div>
            </a>
            
            <a href="{{ route('admin.members.index') }}" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                <i class="fas fa-users text-green-600 text-xl ml-3"></i>
                <div>
                    <h4 class="font-medium text-gray-900">إدارة الأعضاء</h4>
                    <p class="text-sm text-gray-600">إضافة وتعديل أعضاء العائلة</p>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection 