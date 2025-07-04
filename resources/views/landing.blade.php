@extends('layouts.app')

@section('title', 'مرحباً بكم في عائلة أبو جيب')

@section('content')
<!-- Hero Section with Carousel -->
<div class="relative overflow-hidden">
    <!-- Image Carousel -->
    <div class="relative h-[70vh] overflow-hidden">
        <div id="familyCarousel" class="flex transition-transform duration-1000 ease-in-out h-full">
            <!-- Sample family images - replace with actual family photos -->
            <div class="min-w-full h-full bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80')">
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            </div>
            <div class="min-w-full h-full bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80')">
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            </div>
            <div class="min-w-full h-full bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1606092195730-5d7b9af1efc5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80')">
                <div class="absolute inset-0 bg-black bg-opacity-40"></div>
            </div>
        </div>
        
        <!-- Carousel Navigation Dots -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-2">
            <button class="w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all duration-300 carousel-dot active" data-slide="0"></button>
            <button class="w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all duration-300 carousel-dot" data-slide="1"></button>
            <button class="w-3 h-3 rounded-full bg-white bg-opacity-50 hover:bg-opacity-100 transition-all duration-300 carousel-dot" data-slide="2"></button>
        </div>
    </div>

    <!-- Hero Content Overlay -->
    <div class="absolute inset-0 flex items-center justify-center">
        <div class="text-center text-white z-10">
            <div class="mb-6">
                <img src="{{ asset('img/Aboujaib Logo.png') }}" alt="Aboujaib Logo" class="h-20 w-auto mx-auto mb-4">
            </div>
            <h1 class="text-5xl lg:text-7xl font-bold mb-4 animate-fade-in">
                عائلة أبو جيب
            </h1>
            <p class="text-xl lg:text-2xl mb-8 animate-fade-in-delay">
                شجرة عائلة تجمع الماضي والحاضر والمستقبل
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in-delay-2">
                <a href="{{ route('family-tree.index') }}" class="bg-white text-gray-800 hover:bg-gray-100 px-8 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-users ml-2"></i>
                    استكشف العائلة
                </a>
                <a href="{{ route('search.index') }}" class="bg-transparent border-2 border-white text-white hover:bg-white hover:text-gray-800 px-8 py-3 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                    <i class="fas fa-search ml-2"></i>
                    ابحث عن فرد
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Family Information Section -->
<div class="bg-white py-16">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-gray-800 mb-4">عن عائلة أبو جيب</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-purple-600 mx-auto"></div>
        </div>
        
        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <div class="flex items-start space-x-4 space-x-reverse">
                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-history text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">تاريخ عريق</h3>
                        <p class="text-gray-600 leading-relaxed">
                            تمتد جذور عائلة أبو جيب عبر قرون من التاريخ، حيث حمل أفرادها قيم الأصالة والكرامة من جيل إلى جيل، 
                            وتركوا بصمة واضحة في المجتمع من خلال إسهاماتهم في مختلف المجالات.
                        </p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4 space-x-reverse">
                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-green-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-heart text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">قيم عائلية</h3>
                        <p class="text-gray-600 leading-relaxed">
                            تتميز العائلة بقيم التضامن والترابط العائلي القوي، حيث يشكل الحب والاحترام المتبادل 
                            أساس العلاقات بين أفراد العائلة، مما يجعلها نموذجاً للتماسك الاجتماعي.
                        </p>
                    </div>
                </div>
                
                <div class="flex items-start space-x-4 space-x-reverse">
                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-graduation-cap text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">إنجازات علمية</h3>
                        <p class="text-gray-600 leading-relaxed">
                            برز أفراد العائلة في مجالات التعليم والعلوم والثقافة، حيث ساهموا في تطوير المجتمع 
                            من خلال إنجازاتهم العلمية والأكاديمية، وحافظوا على إرث العائلة المعرفي.
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="relative">
                <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl p-8 shadow-xl">
                    <div class="text-center">
                        <img src="{{ asset('img/Aboujaib Logo.png') }}" alt="Aboujaib Logo" class="h-24 w-auto mx-auto mb-6">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">شعار العائلة</h3>
                        <p class="text-gray-600 leading-relaxed">
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
<div class="bg-gradient-to-r from-blue-600 to-purple-700 py-16">
    <div class="container mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-bold text-white mb-4">إحصائيات العائلة</h2>
            <p class="text-xl text-blue-100">أرقام تعكس عظمة عائلة أبو جيب</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="text-4xl font-bold text-white mb-2" id="memberCount">500+</div>
                <p class="text-blue-100">عضو في العائلة</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-white mb-2" id="generationCount">8</div>
                <p class="text-blue-100">أجيال</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-white mb-2" id="yearCount">150+</div>
                <p class="text-blue-100">سنة من التاريخ</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-white mb-2" id="countryCount">5</div>
                <p class="text-blue-100">دول حول العالم</p>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="bg-gray-50 py-16">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">انضم إلى شجرة العائلة</h2>
        <p class="text-xl text-gray-600 mb-8">اكتشف جذورك وتواصل مع أفراد عائلتك</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('family-tree.index') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
                <i class="fas fa-tree ml-2"></i>
                استكشف شجرة العائلة
            </a>
            <a href="{{ route('news.index') }}" class="bg-white border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-8 py-4 rounded-lg font-semibold transition-all duration-300 transform hover:scale-105">
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

<!-- Carousel JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('familyCarousel');
    const dots = document.querySelectorAll('.carousel-dot');
    let currentSlide = 0;
    const totalSlides = 3;
    
    function showSlide(index) {
        carousel.style.transform = `translateX(-${index * 100}%)`;
        
        // Update dots
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });
    }
    
    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }
    
    // Auto-advance carousel every 5 seconds
    setInterval(nextSlide, 5000);
    
    // Dot navigation
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            currentSlide = index;
            showSlide(currentSlide);
        });
    });
    
    // Initialize first slide
    showSlide(0);
});
</script>
@endsection 