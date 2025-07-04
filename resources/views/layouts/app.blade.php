<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'شجرة العائلة') - نظام شجرة العائلة</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="gradient-bg shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ url('/') }}" class="text-white text-xl font-bold flex items-center">
                            <img src="{{ asset('img/Aboujaib Logo.png') }}" alt="Aboujaib Logo" class="h-8 w-auto ml-2">
                            عائِلَةُ أَبُو جَيْب
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ url('/') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-home ml-1"></i> الرئيسية
                    </a>
                    <a href="{{ route('family-tree.index') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-users ml-1"></i> أفراد العائلة
                    </a>
                    <a href="{{ route('search.index') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-search ml-1"></i> بحث
                    </a>
                    <a href="{{ route('news.index') }}" class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium">
                        <i class="fas fa-newspaper ml-1"></i> الأخبار
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="text-center">
                <p>&copy; {{ date('Y') }} نظام شجرة العائلة. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html> 