@extends('layouts.app')

@section('title', 'تعديل معلومات العضو')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">تعديل معلومات العضو</h1>
                <p class="text-gray-600">تحديث معلومات {{ $member->first_name }} {{ $member->last_name }}</p>
            </div>
            <a href="{{ route('admin.members.index') }}" class="bg-gray-600 text-white px-6 py-3 rounded-lg hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-right ml-2"></i> العودة للقائمة
            </a>
        </div>
    </div>

    <!-- Edit Member Form -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">معلومات العضو</h3>
        </div>
        <div class="p-6">
            <form action="{{ route('admin.members.update', $member->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-medium text-gray-900 border-b pb-2">المعلومات الأساسية</h4>
                        
                        <div>
                            <label for="first_name" class="block text-sm font-medium text-gray-700 mb-2">الاسم الأول *</label>
                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $member->first_name) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('first_name') border-red-500 @enderror" required>
                            @error('first_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="last_name" class="block text-sm font-medium text-gray-700 mb-2">اسم العائلة *</label>
                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $member->last_name) }}" 
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
                                <option value="male" {{ old('gender', $member->gender) == 'male' ? 'selected' : '' }}>ذكر</option>
                                <option value="female" {{ old('gender', $member->gender) == 'female' ? 'selected' : '' }}>أنثى</option>
                            </select>
                            @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="is_alive" class="flex items-center">
                                <input type="checkbox" name="is_alive" id="is_alive" value="1" 
                                       {{ old('is_alive', $member->is_alive) ? 'checked' : '' }}
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
                        
                        <div>
                            <label for="father_id" class="block text-sm font-medium text-gray-700 mb-2">الأب</label>
                            <select name="father_id" id="father_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('father_id') border-red-500 @enderror">
                                <option value="">اختر الأب</option>
                                @foreach($potentialParents as $parent)
                                    @if($parent->gender === 'male' && $parent->id !== $member->id)
                                        <option value="{{ $parent->id }}" {{ old('father_id', $member->father_id) == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->first_name }} {{ $parent->last_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('father_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="mother_id" class="block text-sm font-medium text-gray-700 mb-2">الأم</label>
                            <select name="mother_id" id="mother_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('mother_id') border-red-500 @enderror">
                                <option value="">اختر الأم</option>
                                @foreach($potentialParents as $parent)
                                    @if($parent->gender === 'female' && $parent->id !== $member->id)
                                        <option value="{{ $parent->id }}" {{ old('mother_id', $member->mother_id) == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->first_name }} {{ $parent->last_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('mother_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="spouse_id" class="block text-sm font-medium text-gray-700 mb-2">الزوج/الزوجة</label>
                            <select name="spouse_id" id="spouse_id" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('spouse_id') border-red-500 @enderror">
                                <option value="">اختر الزوج/الزوجة</option>
                                @foreach($potentialSpouses as $spouse)
                                    @if($spouse->id !== $member->id)
                                        <option value="{{ $spouse->id }}" {{ old('spouse_id', $member->spouse_id) == $spouse->id ? 'selected' : '' }}>
                                            {{ $spouse->first_name }} {{ $spouse->last_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('spouse_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Current Family Information -->
                @if($member->allChildren()->count() > 0 || $member->spouse)
                <div class="mt-6 space-y-4">
                    <h4 class="text-lg font-medium text-gray-900 border-b pb-2">معلومات العائلة الحالية</h4>
                    
                    @if($member->spouse)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="font-medium text-gray-900 mb-2">الزوج/الزوجة:</h5>
                        <p class="text-gray-700">{{ $member->spouse->first_name }} {{ $member->spouse->last_name }}</p>
                    </div>
                    @endif
                    
                    @if($member->allChildren()->count() > 0)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h5 class="font-medium text-gray-900 mb-2">الأبناء ({{ $member->allChildren()->count() }}):</h5>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @foreach($member->allChildren()->get() as $child)
                            <div class="flex items-center justify-between bg-white p-2 rounded border">
                                <span class="text-gray-700">{{ $child->first_name }} {{ $child->last_name }}</span>
                                <a href="{{ route('admin.members.edit', $child->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endif
                
                <!-- Add Child Section -->
                <div class="mt-6 space-y-4">
                    <h4 class="text-lg font-medium text-gray-900 border-b pb-2">إضافة ابن/ابنة جديد</h4>
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <p class="text-blue-800 mb-4">أضف ابن أو ابنة جديد لـ {{ $member->first_name }} {{ $member->last_name }}</p>
                        <a href="{{ route('admin.members.create') }}?parent_id={{ $member->id }}" 
                           class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                            <i class="fas fa-plus ml-2"></i>
                            إضافة ابن/ابنة جديد
                        </a>
                    </div>
                </div>
                
                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-4 space-x-reverse">
                    <a href="{{ route('admin.members.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600 transition-colors">
                        إلغاء
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save ml-2"></i>
                        حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 