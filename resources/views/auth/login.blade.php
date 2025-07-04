@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="flex justify-center">
                <img src="{{ asset('img/Aboujaib Logo.png') }}" alt="Aboujaib Logo" class="h-20 w-auto">
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                تسجيل الدخول
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                أدخل بيانات الدخول الخاصة بك
            </p>
        </div>
        
        <form class="mt-8 space-y-6" action="{{ route('login.post') }}" method="POST">
            @csrf
            
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="email" class="sr-only">البريد الإلكتروني</label>
                    <input id="email" name="email" type="email" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('email') border-red-500 @enderror"
                           placeholder="البريد الإلكتروني"
                           value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password" class="sr-only">كلمة المرور</label>
                    <input id="password" name="password" type="password" required 
                           class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 focus:z-10 sm:text-sm @error('password') border-red-500 @enderror"
                           placeholder="كلمة المرور">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div>
                <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt text-blue-500 group-hover:text-blue-400"></i>
                    </span>
                    تسجيل الدخول
                </button>
            </div>

            <div class="text-center">
                <p class="text-sm text-gray-600">
                    بيانات تسجيل الدخول الافتراضية للمدير:<br>
                    البريد الإلكتروني: admin@aboujaib.com<br>
                    كلمة المرور: admin123
                </p>
            </div>
        </form>
    </div>
</div>
@endsection 