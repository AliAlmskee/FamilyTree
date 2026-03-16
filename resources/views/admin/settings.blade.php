@extends('layouts.app')

@section('title', 'إعدادات الموقع')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">إعدادات الموقع</h1>
        <p class="text-gray-600">إدارة كلمة مرور الدخول للموقع (يجب على الزوار إدخالها قبل الدخول)</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 max-w-xl">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">كلمة مرور الدخول للموقع</h2>
        <p class="text-sm text-gray-600 mb-4">
            عند تعيين كلمة مرور، سيُطلب من كل زائر إدخالها قبل الدخول إلى الموقع. اترك الحقل فارغاً لإلغاء الحماية والسماح للجميع بالدخول.
        </p>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label for="site_password" class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور</label>
                <input type="text"
                       id="site_password"
                       name="site_password"
                       value="{{ old('site_password') }}"
                       placeholder="{{ $sitePassword ? 'كلمة المرور معطلة - أدخل قيمة جديدة أو اتركه فارغاً لإلغاء الحماية' : 'اتركه فارغاً لعدم الحماية' }}"
                       class="block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm @error('site_password') border-red-500 @enderror">
                @error('site_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @if($sitePassword)
                    <p class="mt-1 text-xs text-amber-600">كلمة المرور مفعّلة. اكتب قيمة جديدة لتغييرها أو اترك الحقل فارغاً ثم احفظ لإلغاء الحماية.</p>
                @else
                    <p class="mt-1 text-xs text-gray-500">الموقع حالياً مفتوح للجميع. أدخل كلمة مرور لتفعيل الحماية.</p>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    حفظ
                </button>
                <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">إلغاء</a>
            </div>
        </form>
    </div>
</div>
@endsection
