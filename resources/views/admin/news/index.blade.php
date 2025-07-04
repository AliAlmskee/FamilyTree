@extends('layouts.app')

@section('title', 'إدارة الأخبار')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">إدارة الأخبار</h1>
        <p class="text-gray-600">عرض وإدارة جميع الأخبار في النظام</p>
    </div>

    <!-- News List -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">قائمة الأخبار</h3>
        </div>
        <div class="p-6">
            @if($news->count() > 0)
                <div class="space-y-6">
                    @foreach($news as $item)
                        <div class="border border-gray-200 rounded-lg p-6">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 space-x-reverse mb-2">
                                        <h4 class="text-lg font-semibold text-gray-900">{{ $item->title }}</h4>
                                        @if($item->is_approved)
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">معتمد</span>
                                        @else
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded">معلق</span>
                                        @endif
                                    </div>
                                    
                                    <p class="text-gray-600 mb-3">{{ Str::limit($item->content, 200) }}</p>
                                    
                                    @if($item->image_path)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="صورة الخبر" class="w-32 h-24 object-cover rounded">
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center space-x-4 space-x-reverse text-sm text-gray-500">
                                        <span><i class="fas fa-calendar ml-1"></i> {{ $item->created_at->format('Y-m-d H:i') }}</span>
                                        <span><i class="fas fa-clock ml-1"></i> {{ $item->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                
                                <div class="flex flex-col space-y-2 space-y-reverse">
                                    @if(!$item->is_approved)
                                        <form action="{{ route('admin.news.approve', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded text-sm hover:bg-green-600 transition-colors">
                                                <i class="fas fa-check ml-1"></i> موافقة
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.news.reject', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded text-sm hover:bg-red-600 transition-colors" onclick="return confirm('هل أنت متأكد من رفض هذا الخبر؟')">
                                                <i class="fas fa-times ml-1"></i> رفض
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.news.delete', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded text-sm hover:bg-gray-600 transition-colors" onclick="return confirm('هل أنت متأكد من حذف هذا الخبر؟')">
                                            <i class="fas fa-trash ml-1"></i> حذف
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-6">
                    {{ $news->links() }}
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-newspaper text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-500 text-lg">لا توجد أخبار في النظام</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Back to Dashboard -->
    <div class="mt-6">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-right ml-2"></i>
            العودة إلى لوحة الإدارة
        </a>
    </div>
</div>
@endsection 