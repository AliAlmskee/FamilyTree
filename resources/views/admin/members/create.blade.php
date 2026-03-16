@extends('layouts.app')

@section('title', 'إضافة عضو جديد')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    @if($parent)
                        إضافة ابن/ابنة لـ {{ $parent->first_name }} {{ $parent->last_name }}
                    @else
                        إضافة عضو جديد
                    @endif
                </h1>
                <p class="text-gray-600">
                    @if($parent)
                        إضافة ابن أو ابنة جديد إلى العائلة
                    @else
                        إضافة عضو جديد إلى شجرة العائلة
                    @endif
                </p>
            </div>
            <a href="{{ route('admin.members.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-right ml-2"></i> العودة للقائمة
            </a>
        </div>
    </div>

    <!-- Add Member Form -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                @if($parent)
                    معلومات الابن/الابنة الجديد
                @else
                    معلومات العضو الجديد
                @endif
            </h3>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.members.store') }}" method="POST">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-medium text-gray-900 border-b pb-2">المعلومات الأساسية</h4>
                        
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">الاسم الأول *</label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('first_name') border-red-500 @enderror" required>
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">اسم العائلة *</label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('last_name') border-red-500 @enderror" required>
                            @error('last_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">الجنس *</label>
                            <select name="gender" id="gender" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('gender') border-red-500 @enderror" required>
                                <option value="">اختر الجنس</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                            </select>
                            @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="is_alive" class="flex items-center">
                                <input type="checkbox" name="is_alive" id="is_alive" value="1" 
                                       {{ old('is_alive', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <span class="mr-2 text-sm font-medium text-gray-700">على قيد الحياة</span>
                            </label>
                            @error('is_alive')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Family Relationships -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-medium text-gray-900 border-b pb-2">العلاقات العائلية</h4>
                        
                        @if($parent)
                            <!-- Pre-select parent based on gender -->
                            @if($parent->gender === 'male')
                                <input type="hidden" name="father_id" value="{{ $parent->id }}">
                                <div class="bg-blue-50 p-4 rounded-lg">
                                    <h5 class="font-medium text-blue-900 mb-2">الأب (محدد تلقائياً):</h5>
                                    <p class="text-blue-700">{{ $parent->first_name }} {{ $parent->last_name }}</p>
                                </div>
                            @else
                                <input type="hidden" name="mother_id" value="{{ $parent->id }}">
                                <div class="bg-pink-50 p-4 rounded-lg">
                                    <h5 class="font-medium text-pink-900 mb-2">الأم (محددة تلقائياً):</h5>
                                    <p class="text-pink-700">{{ $parent->first_name }} {{ $parent->last_name }}</p>
                                </div>
                            @endif
                        @endif
                        
                        @if(!$parent || $parent->gender === 'female')
                        <div>
                            <label for="father_id" class="block text-sm font-medium text-gray-700 mb-2">الأب</label>
                            <input type="text" id="father_id_search" placeholder="بحث..." class="w-full px-3 py-2 border border-gray-300 rounded-t-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-0">
                            <select name="father_id" id="father_id" data-search-input="father_id_search"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-b-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('father_id') border-red-500 @enderror">
                                <option value="">اختر الأب</option>
                                @foreach($potentialParents as $potentialParent)
                                    @if($potentialParent->gender === 'male')
                                        <option value="{{ $potentialParent->id }}" {{ old('father_id') == $potentialParent->id ? 'selected' : '' }}>
                                            {{ $potentialParent->display_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('father_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif
                        
                        @if(!$parent || $parent->gender === 'male')
                        <div>
                            <label for="mother_id" class="block text-sm font-medium text-gray-700 mb-2">الأم</label>
                            <input type="text" id="mother_id_search" placeholder="بحث..." class="w-full px-3 py-2 border border-gray-300 rounded-t-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-0">
                            <select name="mother_id" id="mother_id" data-search-input="mother_id_search"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-b-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('mother_id') border-red-500 @enderror">
                                <option value="">اختر الأم</option>
                                @foreach($potentialParents as $potentialParent)
                                    @if($potentialParent->gender === 'female')
                                        <option value="{{ $potentialParent->id }}" {{ old('mother_id') == $potentialParent->id ? 'selected' : '' }}>
                                            {{ $potentialParent->display_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('mother_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif
                        
                        <div>
                            <label for="spouse_id" class="block text-sm font-medium text-gray-700 mb-2">الزوج/الزوجة</label>
                            <input type="text" id="spouse_id_search" placeholder="بحث..." class="w-full px-3 py-2 border border-gray-300 rounded-t-md focus:outline-none focus:ring-2 focus:ring-blue-500 mb-0">
                            <select name="spouse_id" id="spouse_id" data-search-input="spouse_id_search"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-b-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('spouse_id') border-red-500 @enderror">
                                <option value="">اختر الزوج/الزوجة</option>
                                @foreach($potentialSpouses as $spouse)
                                    <option value="{{ $spouse->id }}" {{ old('spouse_id') == $spouse->id ? 'selected' : '' }}>
                                        {{ $spouse->display_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('spouse_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                
                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-4 space-x-reverse">
                    <a href="{{ route('admin.members.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition-colors">
                        إلغاء
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save ml-2"></i>
                        @if($parent)
                            إضافة الابن/الابنة
                        @else
                            إضافة العضو
                        @endif
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('select[data-search-input]').forEach(function(select) {
        var searchInput = document.getElementById(select.getAttribute('data-search-input'));
        if (!searchInput) return;

        var allOptions = [];
        select.querySelectorAll('option').forEach(function(opt) {
            if (opt.value !== '') {
                allOptions.push({ value: opt.value, text: opt.textContent.trim() });
            }
        });

        function applyFilter() {
            var q = searchInput.value.trim().toLowerCase();
            var currentValue = select.value;
            var currentOpt = allOptions.find(function(o) { return o.value === currentValue; });
            select.innerHTML = '';
            var emptyOpt = document.createElement('option');
            emptyOpt.value = '';
            emptyOpt.textContent = select.id === 'father_id' ? 'اختر الأب' : (select.id === 'mother_id' ? 'اختر الأم' : 'اختر الزوج/الزوجة');
            select.appendChild(emptyOpt);
            var addedCurrent = false;
            allOptions.forEach(function(opt) {
                if (q === '' || opt.text.toLowerCase().indexOf(q) !== -1) {
                    var o = document.createElement('option');
                    o.value = opt.value;
                    o.textContent = opt.text;
                    if (opt.value === currentValue) { o.selected = true; addedCurrent = true; }
                    select.appendChild(o);
                }
            });
            if (currentValue && !addedCurrent && currentOpt) {
                var o = document.createElement('option');
                o.value = currentOpt.value;
                o.textContent = currentOpt.text;
                o.selected = true;
                select.appendChild(o);
            }
        }

        searchInput.addEventListener('input', applyFilter);
    });
});
</script>
@endpush
@endsection