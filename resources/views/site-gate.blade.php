@extends('layouts.app')

@section('title', 'كلمة مرور الموقع')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-6">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="flex justify-center">
                <img src="{{ asset('img/Aboujaib Logo.png') }}" alt="Aboujaib Logo" class="h-20 w-auto">
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                كلمة مرور الموقع
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                يرجى إدخال كلمة المرور للدخول إلى الموقع
            </p>
        </div>

        <form class="mt-8 space-y-6" action="{{ route('site-gate.post') }}" method="POST">
            @csrf
            <div>
                <label for="gate_password" class="sr-only">كلمة المرور</label>
                <input id="gate_password" name="gate_password" type="password" required autofocus
                       class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('gate_password') border-red-500 @enderror"
                       placeholder="كلمة المرور">
                @error('gate_password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
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
                    <span class="absolute right-0 inset-y-0 flex items-center pr-3">
                        <i class="fas fa-lock text-blue-500 group-hover:text-blue-400"></i>
                    </span>
                    دخول
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
