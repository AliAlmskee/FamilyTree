@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="flex items-center justify-center min-h-[60vh]">
    <div class="container mx-auto px-6 py-12">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 md:pr-12 text-center md:text-left mb-8 md:mb-0">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-800">Welcome to aboujeib Family Tree</h1>
                <p class="text-xl text-gray-600 mt-4">Discover your roots and connect with your heritage.</p>
            </div>
            <div class="md:w-1/2">
                <img src="{{ asset('img/Aboujaib Logo.png') }}" alt="Calligraphy" class="w-full h-auto rounded-lg shadow-2xl">
            </div>
        </div>
    </div>
</div>
@endsection 