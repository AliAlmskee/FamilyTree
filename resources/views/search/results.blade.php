@extends('layouts.app')

@section('title', 'نتائج البحث')

@section('content')
<div class="space-y-6">
    <!-- Breadcrumb -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('search.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <i class="fas fa-search ml-2"></i>
                    بحث
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-left text-gray-400 mx-2"></i>
                    <span class="text-sm font-medium text-gray-500">النتائج</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Search Header -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">نتائج البحث</h1>
                <p class="text-gray-600 mt-1">
                    @if($results->count() > 0)
                        تم العثور على {{ $results->count() }} فرد من أفراد العائلة لـ "{{ $name }}"
                    @else
                        لم يتم العثور على أفراد من العائلة لـ "{{ $name }}"
                    @endif
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('search.index') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-search ml-2"></i>
                    بحث جديد
                </a>
                <a href="{{ route('family-tree.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-list ml-2"></i>
                    كل الأفراد
                </a>
            </div>
        </div>
    </div>

    <!-- Search Results -->
    @if($results->count() > 0)
        <!-- Results Summary -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-blue-800 font-medium">
                        <i class="fas fa-info-circle ml-1"></i>
                        ملخص نتائج البحث
                    </span>
                    <span class="text-blue-700">
                        {{ $results->count() }} نتيجة
                    </span>
                </div>
                <div class="text-sm text-blue-700">
                    مصطلح البحث: "<strong>{{ $name }}</strong>"
                </div>
            </div>
        </div>

        <!-- Results Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($results as $member)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                    <!-- Member Header -->
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center space-x-4">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center text-white text-xl font-bold">
                                {{ strtoupper(substr($member->first_name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    <a href="{{ route('family-tree.show', $member->id) }}" 
                                       class="hover:text-blue-600 transition-colors">
                                        {{ $member->first_name }} {{ $member->last_name }}
                                    </a>
                                </h3>
                                @if($member->maiden_name)
                                    <p class="text-sm text-gray-600">({{ $member->maiden_name }})</p>
                                @endif
                                <div class="flex items-center mt-2 space-x-2">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $member->gender === 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                        <i class="fas fa-{{ $member->gender === 'male' ? 'male' : 'female' }} ml-1"></i>
                                        {{ $member->gender === 'male' ? 'ذكر' : 'أنثى' }}
                                    </span>
                                    @if($member->birth_date)
                                        <span class="text-xs text-gray-500">
                                            <i class="fas fa-birthday-cake ml-1"></i>
                                            {{ \Carbon\Carbon::parse($member->birth_date)->format('Y') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Member Details -->
                    <div class="p-6 space-y-4">
                        <!-- Family Information -->
                        <div class="space-y-3">
                            @if($member->father)
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-male text-blue-600 mr-2 w-4"></i>
                                    <span class="text-gray-600 ml-2">الأب:</span>
                                    <a href="{{ route('family-tree.show', $member->father->id) }}" 
                                       class="text-blue-600 hover:text-blue-800">
                                        {{ $member->father->first_name }} {{ $member->father->last_name }}
                                    </a>
                                </div>
                            @endif
                            
                            @if($member->mother)
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-female text-pink-600 mr-2 w-4"></i>
                                    <span class="text-gray-600 ml-2">الأم:</span>
                                    <a href="{{ route('family-tree.show', $member->mother->id) }}" 
                                       class="text-blue-600 hover:text-blue-800">
                                        {{ $member->mother->first_name }} {{ $member->mother->last_name }}
                                    </a>
                                </div>
                            @endif
                            
                            @if($member->spouse)
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-heart text-red-600 mr-2 w-4"></i>
                                    <span class="text-gray-600 ml-2">الزوج/الزوجة:</span>
                                    <a href="{{ route('family-tree.show', $member->spouse->id) }}" 
                                       class="text-blue-600 hover:text-blue-800">
                                        {{ $member->spouse->first_name }} {{ $member->spouse->last_name }}
                                    </a>
                                </div>
                            @endif
                            
                            @if($member->children->count() > 0)
                                <div class="flex items-center text-sm">
                                    <i class="fas fa-baby text-green-600 mr-2 w-4"></i>
                                    <span class="text-gray-600 ml-2">الأبناء:</span>
                                    <span class="text-gray-900">{{ $member->children->count() }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Additional Details -->
                        @if($member->birth_place)
                            <div class="flex items-center text-sm">
                                <i class="fas fa-map-marker-alt text-gray-500 mr-2 w-4"></i>
                                <span class="text-gray-600">{{ $member->birth_place }}</span>
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="flex space-x-2 pt-4 border-t border-gray-200">
                            <a href="{{ route('family-tree.show', $member->id) }}" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center px-3 py-2 rounded text-sm">
                                <i class="fas fa-eye ml-1"></i>
                                عرض الملف الشخصي
                            </a>
                            <a href="{{ route('family-tree.ancestry', $member->id) }}" 
                               class="bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-sm">
                                <i class="fas fa-arrow-up"></i>
                            </a>
                            <a href="{{ route('family-tree.descendants', $member->id) }}" 
                               class="bg-purple-600 hover:bg-purple-700 text-white px-3 py-2 rounded text-sm">
                                <i class="fas fa-arrow-down"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- No Results Message -->
    @else
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <div class="mb-6">
                <i class="fas fa-search text-6xl text-gray-300"></i>
            </div>
            <h3 class="text-xl font-medium text-gray-900 mb-2">لم يتم العثور على أفراد من العائلة</h3>
            <p class="text-gray-600 mb-6">
                لم نتمكن من العثور على أي فرد من أفراد العائلة يطابق "<strong>{{ $name }}</strong>".
            </p>
            <div class="space-y-4">
                <p class="text-sm text-gray-500">جرب هذه الاقتراحات:</p>
                <ul class="text-sm text-gray-500 space-y-1">
                    <li>• تحقق من تهجئة الاسم</li>
                    <li>• حاول البحث بالاسم الأول أو اسم العائلة فقط</li>
                    <li>• استخدم أسماء جزئية لنتائج أوسع</li>
                    <li>• تحقق مما إذا كان الشخص قد يكون مدرجًا تحت اسم مختلف</li>
                </ul>
            </div>
            <div class="mt-8 space-x-4">
                <a href="{{ route('search.index') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-flex items-center">
                    <i class="fas fa-search ml-2"></i>
                    جرب بحثًا آخر
                </a>
                <a href="{{ route('family-tree.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg inline-flex items-center">
                    <i class="fas fa-list ml-2"></i>
                    عرض كل الأفراد
                </a>
            </div>
        </div>
    @endif

    <!-- Search Tips -->
    @if($results->count() > 0)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
            <div class="flex items-start">
                <i class="fas fa-lightbulb text-yellow-600 mt-1 mr-3"></i>
                <div>
                    <h3 class="text-lg font-medium text-yellow-900 mb-2">نصائح للبحث</h3>
                    <ul class="text-yellow-800 space-y-1">
                        <li>• انقر على اسم أي فرد من أفراد العائلة لعرض ملفه الشخصي الكامل</li>
                        <li>• استخدم أزرار الأسهم لاستكشاف الأسلاف (↑) أو الأبناء (↓)</li>
                        <li>• جرب مصطلحات بحث مختلفة للعثور على المزيد من أفراد العائلة</li>
                        <li>• تحقق من صفحة "كل الأفراد" لتصفح شجرة العائلة الكاملة</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Add hover effects for result cards
        const cards = document.querySelectorAll('.transition-shadow');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.classList.add('shadow-xl');
            });
            card.addEventListener('mouseleave', () => {
                card.classList.remove('shadow-xl');
            });
        });
    });
</script>
@endpush
@endsection 