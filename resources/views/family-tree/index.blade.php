@extends('layouts.app')

@section('title', 'أفراد العائلة')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">أفراد العائلة</h1>
            <p class="text-gray-600 mt-1">تصفح وإدارة أفراد شجرة عائلتك</p>
        </div>
    </div>

    <!-- Search Bar -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <form action="{{ route('search.by-name') }}" method="GET" class="flex gap-4">
            <div class="flex-1">
                <input type="text" 
                       name="name" 
                       placeholder="البحث بالاسم..." 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-right">
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center">
                <i class="fas fa-search ml-2"></i>
                بحث
            </button>
        </form>
    </div>

    <!-- Members Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold text-gray-900">كل أفراد العائلة</h2>
        </div>
        
        @if($members->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الفرد
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الجنس
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الأب
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الأم
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الزوج/الزوجة
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الأبناء
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                الإجراءات
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($members as $member)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center text-white font-semibold">
                                            {{ strtoupper(substr($member->first_name, 0, 1)) }}
                                        </div>
                                        <div class="mr-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $member->first_name }} {{ $member->last_name }}
                                            </div>
                                            @if($member->maiden_name)
                                                <div class="text-sm text-gray-500">
                                                    ({{ $member->maiden_name }})
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $member->gender === 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                        <i class="fas fa-{{ $member->gender === 'male' ? 'male' : 'female' }} ml-1"></i>
                                        {{ $member->gender === 'male' ? 'ذكر' : 'أنثى' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($member->father)
                                        <a href="{{ route('family-tree.show', $member->father->id) }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $member->father->first_name }} {{ $member->father->last_name }}
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($member->mother)
                                        <a href="{{ route('family-tree.show', $member->mother->id) }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $member->mother->first_name }} {{ $member->mother->last_name }}
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($member->spouse)
                                        <a href="{{ route('family-tree.show', $member->spouse->id) }}" class="text-blue-600 hover:text-blue-800">
                                            {{ $member->spouse->first_name }} {{ $member->spouse->last_name }}
                                        </a>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $member->children->count() }} أبناء
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-left text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('family-tree.show', $member->id) }}" 
                                           class="text-blue-600 hover:text-blue-900">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('family-tree.ancestry', $member->id) }}" 
                                           class="text-green-600 hover:text-green-900">
                                            <i class="fas fa-arrow-up"></i>
                                        </a>
                                        <a href="{{ route('family-tree.descendants', $member->id) }}" 
                                           class="text-purple-600 hover:text-purple-900">
                                            <i class="fas fa-arrow-down"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $members->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">لم يتم العثور على أفراد من العائلة</h3>
                <p class="text-gray-500 mb-6">ابدأ في بناء شجرة عائلتك عن طريق استيراد البيانات من ملف Excel.</p>
                {{-- <a href="{{ route('import.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-flex items-center">
                    <i class="fas fa-upload ml-2"></i>
                    استيراد بيانات العائلة
                </a> --}}
            </div>
        @endif
    </div>
</div>
@endsection 