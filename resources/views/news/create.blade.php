@extends('layouts.app')

@section('title', 'أضف خبراً')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-lg">
        <div class="p-6 md:p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">إنشاء مقال إخباري جديد</h1>
            <p class="text-gray-600 mb-6">املأ النموذج أدناه لإرسال مقال جديد للموافقة عليه.</p>

            @if ($errors->any())
                <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
                    <p class="font-bold">الرجاء تصحيح الأخطاء التالية:</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">العنوان</label>
                    <input type="text" name="title" id="title" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" value="{{ old('title') }}" required>
                </div>

                <div>
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-1">المحتوى</label>
                    <textarea name="content" id="content" rows="10" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>{{ old('content') }}</textarea>
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-1">صورة (اختياري)</label>
                    <input type="file" name="image" id="image" class="w-full text-sm text-gray-500 file:ml-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div class="flex justify-end pt-4">
                    <a href="{{ route('news.index') }}" class="text-gray-600 hover:text-gray-800 font-semibold py-2 px-4 ml-4">إلغاء</a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                        إرسال للموافقة
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 