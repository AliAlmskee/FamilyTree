@extends('layouts.app')

@section('title', $newsItem->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            @if($newsItem->image_path)
                <img src="{{ asset('storage/' . $newsItem->image_path) }}" alt="{{ $newsItem->title }}" class="w-full h-96 object-cover">
            @endif
            <div class="p-6 md:p-8">
                <h1 class="text-4xl font-bold text-gray-900 mb-2">{{ $newsItem->title }}</h1>
                <p class="text-sm text-gray-500 mb-6">نشر في {{ $newsItem->created_at->format('F j, Y') }}</p>
                <div class="prose prose-lg max-w-none text-gray-700">
                    {!! nl2br(e($newsItem->content)) !!}
                </div>
            </div>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('news.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                <i class="fas fa-arrow-right mr-2"></i>
                العودة إلى الأخبار
            </a>
        </div>
    </div>
</div>
@endsection 