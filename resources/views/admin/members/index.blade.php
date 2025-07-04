@extends('layouts.app')

@section('title', 'إدارة أعضاء العائلة')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">إدارة أعضاء العائلة</h1>
                <p class="text-gray-600">عرض وإدارة جميع أعضاء العائلة</p>
            </div>
            <a href="{{ route('admin.members.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus ml-2"></i> إضافة عضو جديد
            </a>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg shadow-md mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">البحث والتصفية</h3>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('admin.members.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">البحث بالاسم</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="ابحث بالاسم الأول أو الأخير...">
                </div>
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">الجنس</label>
                    <select name="gender" id="gender" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">جميع الأجناس</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>ذكر</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>أنثى</option>
                    </select>
                </div>
                <div>
                    <label for="is_alive" class="block text-sm font-medium text-gray-700 mb-2">الحالة</label>
                    <select name="is_alive" id="is_alive" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">جميع الحالات</option>
                        <option value="1" {{ request('is_alive') == '1' ? 'selected' : '' }}>حي</option>
                        <option value="0" {{ request('is_alive') == '0' ? 'selected' : '' }}>متوفى</option>
                    </select>
                </div>
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">ترتيب حسب</label>
                    <select name="sort" id="sort" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>تاريخ الإضافة</option>
                        <option value="first_name" {{ request('sort') == 'first_name' ? 'selected' : '' }}>الاسم الأول</option>
                        <option value="last_name" {{ request('sort') == 'last_name' ? 'selected' : '' }}>اسم العائلة</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-search ml-2"></i> بحث
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Members List -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">قائمة الأعضاء ({{ $members->total() }})</h3>
                @if(request('search') || request('gender') || request('is_alive') || request('sort'))
                    <a href="{{ route('admin.members.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                        <i class="fas fa-times ml-1"></i> مسح الفلاتر
                    </a>
                @endif
            </div>
        </div>
        <div class="p-6">
            @if($members->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الاسم</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الجنس</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الحالة</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الأب</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الأم</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الزوج/الزوجة</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الأبناء</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ الإضافة</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($members as $member)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                                    <i class="fas fa-user text-gray-600"></i>
                                                </div>
                                            </div>
                                            <div class="mr-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $member->first_name }} {{ $member->last_name }}
                                                </div>
                                                @if($member->maiden_name)
                                                    <div class="text-sm text-gray-500">
                                                        {{ $member->maiden_name }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $member->gender === 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                            {{ $member->gender === 'male' ? 'ذكر' : 'أنثى' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($member->is_alive)
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                حي
                                            </span>
                                        @else
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                متوفى
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($member->father)
                                            <a href="{{ route('admin.members.edit', $member->father->id) }}" class="text-blue-600 hover:text-blue-800">
                                                {{ $member->father->first_name }} {{ $member->father->last_name }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">غير محدد</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($member->mother)
                                            <a href="{{ route('admin.members.edit', $member->mother->id) }}" class="text-blue-600 hover:text-blue-800">
                                                {{ $member->mother->first_name }} {{ $member->mother->last_name }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">غير محدد</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($member->spouse)
                                            <a href="{{ route('admin.members.edit', $member->spouse->id) }}" class="text-blue-600 hover:text-blue-800">
                                                {{ $member->spouse->first_name }} {{ $member->spouse->last_name }}
                                            </a>
                                        @else
                                            <span class="text-gray-400">غير محدد</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($member->allChildren()->count() > 0)
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                {{ $member->allChildren()->count() }} أبناء
                                            </span>
                                        @else
                                            <span class="text-gray-400">لا يوجد</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $member->created_at->format('Y-m-d') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2 space-x-reverse">
                                            <a href="{{ route('admin.members.edit', $member->id) }}" class="text-blue-600 hover:text-blue-900" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="{{ route('admin.members.create') }}?parent_id={{ $member->id }}" class="text-green-600 hover:text-green-900" title="إضافة ابن">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                            <form action="{{ route('admin.members.delete', $member->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('هل أنت متأكد من حذف هذا العضو؟')" title="حذف">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-6">
                    {{ $members->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-500 text-lg">لا توجد أعضاء في العائلة</p>
           
                </div>
            @endif
        </div>
    </div>
    
    <!-- Back to Dashboard -->
    <div class="mt-6">
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-right ml-2"></i>
            العودة إلى لوحة الإدارة
        </a>
    </div>
</div>
@endsection 