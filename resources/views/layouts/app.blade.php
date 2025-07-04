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
            <div class="flex justify-between h-12 sm:h-14 lg:h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="{{ url('/') }}" class="text-white text-base sm:text-lg lg:text-xl font-bold flex items-center">
                            <img src="{{ asset('img/Aboujaib Logo.png') }}" alt="Aboujaib Logo" class="h-6 w-auto sm:h-7 lg:h-8 ml-2">
                            <span class="hidden sm:inline">عائِلَةُ أَبُو جَيْب</span>
                            <span class="sm:hidden">أبو جيب</span>
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <a href="{{ route('family-tree.index') }}" class="text-white hover:text-gray-200 px-2 sm:px-3 py-1 sm:py-2 rounded-md text-xs sm:text-sm font-medium transition-colors duration-200">
                        <i class="fas fa-users ml-1"></i>
                        <span class="hidden sm:inline">أفراد العائلة</span>
                        <span class="sm:hidden">العائلة</span>
                    </a>
                    <a href="{{ route('search.index') }}" class="text-white hover:text-gray-200 px-2 sm:px-3 py-1 sm:py-2 rounded-md text-xs sm:text-sm font-medium transition-colors duration-200">
                        <i class="fas fa-search ml-1"></i>
                        <span class="hidden sm:inline">بحث</span>
                        <span class="sm:hidden">بحث</span>
                    </a>
                    <a href="{{ route('news.index') }}" class="text-white hover:text-gray-200 px-2 sm:px-3 py-1 sm:py-2 rounded-md text-xs sm:text-sm font-medium transition-colors duration-200">
                        <i class="fas fa-newspaper ml-1"></i>
                        <span class="hidden sm:inline">الأخبار</span>
                        <span class="sm:hidden">الأخبار</span>
                    </a>
                    
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <!-- Admin Dashboard Link -->
                            <a href="{{ route('admin.dashboard') }}" class="text-white hover:text-gray-200 px-2 sm:px-3 py-1 sm:py-2 rounded-md text-xs sm:text-sm font-medium transition-colors duration-200 bg-red-600 bg-opacity-50 rounded">
                                <i class="fas fa-cog ml-1"></i>
                                <span class="hidden sm:inline">الإدارة</span>
                                <span class="sm:hidden">الإدارة</span>
                            </a>
                            
                            <!-- Admin Logout -->
                            <div class="relative group">
                                <button class="text-white hover:text-gray-200 px-2 sm:px-3 py-1 sm:py-2 rounded-md text-xs sm:text-sm font-medium transition-colors duration-200 flex items-center">
                                    <i class="fas fa-user-shield ml-1"></i>
                                    <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                                    <span class="sm:hidden">مدير</span>
                                    <i class="fas fa-chevron-down mr-1 text-xs"></i>
                                </button>
                                <div class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200">
                                    <form method="POST" action="{{ route('logout') }}" class="block">
                                        @csrf
                                        <button type="submit" class="block w-full text-right px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-sign-out-alt ml-2"></i>
                                            تسجيل الخروج
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif   
                    @endauth
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
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6 lg:py-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
            <div class="text-center">
                <p class="text-sm sm:text-base">&copy; {{ date('Y') }} نظام شجرة العائلة. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @stack('scripts')
</body>
</html> 