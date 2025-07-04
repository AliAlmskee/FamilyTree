@extends('layouts.app')

@section('title', 'إدارة المستخدمين')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">إدارة المستخدمين</h1>
                <p class="text-gray-600">عرض وإدارة جميع المستخدمين في النظام</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus ml-2"></i> إضافة مستخدم جديد
            </a>
        </div>
    </div>

    <!-- Users List -->
    <div class="bg-white rounded-lg shadow-md">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">قائمة المستخدمين</h3>
        </div>
        <div class="p-6">
            @if($users->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">المستخدم</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">البريد الإلكتروني</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الدور</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">تاريخ التسجيل</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
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
                                                    {{ $user->name }}
                                                </div>
                                                @if($user->id === auth()->id())
                                                    <div class="text-xs text-blue-600">أنت</div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $user->role === 'admin' ? 'مدير' : 'مستخدم' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $user->created_at->format('Y-m-d') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2 space-x-reverse">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-edit"></i> تعديل
                                            </a>
                                            @if($user->id !== auth()->id())
                                                <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                                        <i class="fas fa-trash"></i> حذف
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="mt-6">
                    {{ $users->links() }}
                </div>
            @else
                <div class="text-center py-8">
                    <i class="fas fa-users text-gray-400 text-4xl mb-4"></i>
                    <p class="text-gray-500 text-lg">لا توجد مستخدمين في النظام</p>
                    <a href="{{ route('admin.users.create') }}" class="mt-4 inline-flex items-center text-blue-600 hover:text-blue-800">
                        <i class="fas fa-plus ml-2"></i> إضافة أول مستخدم
                    </a>
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