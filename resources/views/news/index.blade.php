@extends('layouts.app')

@section('title', 'الأخبار')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">آخر الأخبار</h1>
        <a href="{{ route('news.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
            <i class="fas fa-plus ml-2"></i>
            أضف خبراً
        </a>
    </div>

    @if($newsItems->count() > 0)
        <div class="space-y-8">
            @foreach($newsItems as $item)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    @if($item->image_path)
                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-full h-64 object-cover">
                    @endif
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $item->title }}</h2>
                        <p class="text-gray-600 mb-4">{{ Str::limit($item->content, 150) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">{{ $item->created_at->format('F j, Y') }}</span>
                            <a href="{{ route('news.show', $item) }}" class="text-blue-600 hover:text-blue-800 font-semibold">&larr; إقرأ المزيد</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $newsItems->links() }}
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-lg shadow-md">
            <i class="fas fa-newspaper text-6xl text-gray-300 mb-4"></i>
            <h2 class="text-2xl font-semibold text-gray-700 mb-2">لا توجد أخبار بعد</h2>
            <p class="text-gray-500">تحقق مرة أخرى لاحقًا للحصول على آخر التحديثات.</p>
        </div>
    @endif
</div>
@endsection 