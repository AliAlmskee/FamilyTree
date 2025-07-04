@extends('layouts.app')

@section('title', 'مرحباً بكم في عائلة أبو جيب')

@section('content')
<!-- Hero Section with Carousel -->
<div class="relative overflow-hidden">
    <!-- Image Carousel -->
    <div class="relative h-[50vh] sm:h-[60vh] md:h-[70vh] lg:h-[80vh] overflow-hidden">
        <div id="familyCarousel" class="flex transition-transform duration-1000 ease-in-out h-full">
            <!-- Family images -->
            <div class="min-w-full h-full bg-cover bg-center" style="background-image: url('{{ asset('img/family1.jpg') }}')">
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            </div>
        </div>
    </div>

    <!-- Hero Content Overlay -->
    <div class="absolute inset-0 flex items-center justify-center">
        <div class="text-center text-white z-10 px-4 sm:px-6 lg:px-8">
            <div class="mb-4 sm:mb-6">
                <img src="{{ asset('img/Aboujaib Logo.png') }}" alt="Aboujaib Logo" class="h-12 w-auto sm:h-16 md:h-20 lg:h-24 mx-auto mb-2 sm:mb-4">
            </div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl xl:text-6xl 2xl:text-7xl font-bold mb-2 sm:mb-4 animate-fade-in leading-tight">
                عائلة أبو جيب
            </h1>
            <p class="text-sm sm:text-base md:text-lg lg:text-xl xl:text-2xl mb-4 sm:mb-6 lg:mb-8 animate-fade-in-delay leading-relaxed max-w-2xl mx-auto">
                شجرة عائلة تجمع الماضي والحاضر والمستقبل
            </p>
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-4 justify-center animate-fade-in-delay-2">
                <a href="{{ route('family-tree.index') }}" class="bg-white text-gray-800 hover:bg-gray-100 px-4 sm:px-6 lg:px-8 py-2 sm:py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 text-sm sm:text-base">
                    <i class="fas fa-users ml-2"></i>
                    استكشف العائلة
                </a>
                <a href="{{ route('search.index') }}" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-gray-800 px-4 sm:px-6 lg:px-8 py-2 sm:py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 text-sm sm:text-base">
                    <i class="fas fa-search ml-2"></i>
                    ابحث عن فرد
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Family Information Section -->
<div class="bg-white py-8 sm:py-12 lg:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-800 mb-2 sm:mb-4 leading-tight">عن عائلة أبو جيب</h2>
            <div class="w-16 sm:w-20 lg:w-24 h-1 bg-gradient-to-r from-blue-500 to-purple-600 mx-auto"></div>
        </div>
        
        <div class="grid md:grid-cols-2 gap-8 sm:gap-12 items-center">
            <div class="space-y-4 sm:space-y-6">
                <div class="flex items-start space-x-3 sm:space-x-4 space-x-reverse">
                    <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-history text-white text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl lg:text-2xl font-semibold text-gray-800 mb-1 sm:mb-2">تاريخ عريق</h3>
                        <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                            تمتد جذور عائلة أبو جيب عبر قرون من التاريخ، حيث حمل أفرادها قيم الأصالة والكرامة من جيل إلى جيل، 
                            وتركوا بصمة واضحة في المجتمع من خلال إسهاماتهم في مختلف المجالات.
                        </p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 sm:space-x-4 space-x-reverse">
                    <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-green-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-heart text-white text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl lg:text-2xl font-semibold text-gray-800 mb-1 sm:mb-2">قيم عائلية</h3>
                        <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                            تتميز العائلة بقيم التضامن والترابط العائلي القوي، حيث يشكل الحب والاحترام المتبادل 
                            أساس العلاقات بين أفراد العائلة، مما يجعلها نموذجاً للتماسك الاجتماعي.
                        </p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-3 sm:space-x-4 space-x-reverse">
                    <div class="flex-shrink-0 w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-lg sm:text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg sm:text-xl lg:text-2xl font-semibold text-gray-800 mb-1 sm:mb-2">إنجازات علمية</h3>
                        <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                            برز أفراد العائلة في مجالات التعليم والعلوم والثقافة، حيث ساهموا في تطوير المجتمع 
                            من خلال إنجازاتهم العلمية والأكاديمية، وحافظوا على إرث العائلة المعرفي.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="relative">
                <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-4 sm:p-6 lg:p-8 shadow-xl">
                    <div class="text-center">
                        <img src="{{ asset('img/Aboujaib Logo.png') }}" alt="Aboujaib Logo" class="h-16 w-auto sm:h-20 lg:h-24 mx-auto mb-4 sm:mb-6">
                        <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold text-gray-800 mb-2 sm:mb-4">شعار العائلة</h3>
                        <p class="text-sm sm:text-base text-gray-600 leading-relaxed">
                            يمثل هذا الشعار هوية عائلة أبو جيب وتراثها العريق، حيث يجسد القيم والمبادئ 
                            التي تربى عليها أفراد العائلة عبر الأجيال، ويرمز إلى الوحدة والتماسك العائلي.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<div class="bg-gradient-to-r from-blue-600 to-purple-700 py-8 sm:py-12 lg:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8 sm:mb-12">
            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-2 sm:mb-4 leading-tight">إحصائيات العائلة</h2>
            <p class="text-base sm:text-lg lg:text-xl text-blue-100">أرقام تعكس عائلة أبو جيب</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            <div class="text-center">
                <div class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-1 sm:mb-2" id="memberCount">0</div>
                <p class="text-sm sm:text-base text-blue-100">إجمالي الأعضاء</p>
            </div>
            <div class="text-center">
                <div class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-1 sm:mb-2" id="aliveCount">0</div>
                <p class="text-sm sm:text-base text-blue-100">الأعضاء الأحياء</p>
            </div>
            <div class="text-center">
                <div class="text-2xl sm:text-3xl lg:text-4xl font-bold text-white mb-1 sm:mb-2" id="generationCount">0</div>
                <p class="text-sm sm:text-base text-blue-100">أجيال</p>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="bg-gray-50 py-8 sm:py-12 lg:py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-800 mb-2 sm:mb-4 leading-tight">انضم إلى شجرة العائلة</h2>
        <p class="text-base sm:text-lg lg:text-xl text-gray-600 mb-6 sm:mb-8 max-w-2xl mx-auto">اكتشف جذورك وتواصل مع أفراد عائلتك</p>
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
            <a href="{{ route('family-tree.index') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 text-sm sm:text-base">
                <i class="fas fa-tree ml-2"></i>
                استكشف شجرة العائلة
            </a>
            <a href="{{ route('news.index') }}" class="bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-6 sm:px-8 py-3 sm:py-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105 text-sm sm:text-base">
                <i class="fas fa-newspaper ml-2"></i>
                آخر الأخبار
            </a>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
    .animate-fade-in {
        animation: fadeIn 1s ease-in;
    }
    
    .animate-fade-in-delay {
        animation: fadeIn 1s ease-in 0.3s both;
    }
    
    .animate-fade-in-delay-2 {
        animation: fadeIn 1s ease-in 0.6s both;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .carousel-dot.active {
        background-color: white;
        opacity: 1;
    }
</style>

<!-- JavaScript for Statistics -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fetch family statistics
    fetch('{{ route("api.family-stats") }}')
        .then(response => response.json())
        .then(data => {
            // Update the statistics with real data
            document.getElementById('memberCount').textContent = data.total_members;
            document.getElementById('aliveCount').textContent = data.alive_members;
            document.getElementById('generationCount').textContent = data.generations;
        })
        .catch(error => {
            console.error('Error fetching family statistics:', error);
            // Set default values if API fails
            document.getElementById('memberCount').textContent = '0';
            document.getElementById('aliveCount').textContent = '0';
            document.getElementById('generationCount').textContent = '1';
        });
});
</script>
@endsection 