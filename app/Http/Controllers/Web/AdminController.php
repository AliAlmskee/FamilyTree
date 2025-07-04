<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\FamilyMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function createAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'تم إنشاء مدير النظام بنجاح');
    }

    public function dashboard()
    {
        $stats = [
            'total_members' => FamilyMember::count(),
            'pending_news' => News::where('is_approved', false)->count(),
            'approved_news' => News::where('is_approved', true)->count(),
        ];

        $pendingNews = News::where('is_approved', false)->latest()->take(5)->get();
        $recentMembers = FamilyMember::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'pendingNews', 'recentMembers'));
    }

    // News Management
    public function newsIndex()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function approveNews($id)
    {
        $news = News::findOrFail($id);
        $news->update(['is_approved' => true]);
        
        return redirect()->back()->with('success', 'تم الموافقة على الخبر بنجاح');
    }

    public function rejectNews($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
        
        return redirect()->back()->with('success', 'تم رفض الخبر وحذفه بنجاح');
    }

    public function deleteNews($id)
    {
        $news = News::findOrFail($id);
        
        // Delete image if exists
        if ($news->image_path && Storage::exists($news->image_path)) {
            Storage::delete($news->image_path);
        }
        
        $news->delete();
        
        return redirect()->back()->with('success', 'تم حذف الخبر بنجاح');
    }

    // Family Member Management
    public function membersIndex(Request $request)
    {
        $query = FamilyMember::with(['father', 'mother', 'spouse']);
        
        // Search by name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }
        
        // Filter by gender
        if ($request->filled('gender')&& $request->gender != '') {
            $query->where('gender', $request->gender);
        }

        // Filter by alive status
        if ($request->has('is_alive') && $request->is_alive != '') {
            $query->where('is_alive', $request->is_alive);
        }
        
        // Sort
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        
        if (in_array($sort, ['first_name', 'last_name', 'created_at'])) {
            $query->orderBy($sort, $direction);
        } else {
            $query->latest();
        }
        
        $members = $query->paginate(15);
        return view('admin.members.index', compact('members'));
    }

    public function memberEdit($id)
    {
        $member = FamilyMember::with(['father', 'mother', 'spouse'])->findOrFail($id);
        $potentialParents = FamilyMember::where('id', '!=', $id)->get();
        $potentialSpouses = FamilyMember::where('id', '!=', $id)->get();
        
        return view('admin.members.edit', compact('member', 'potentialParents', 'potentialSpouses'));
    }

    public function memberUpdate(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'maiden_name' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|array',
            'life_description' => 'nullable|string',
            'is_alive' => 'boolean',
            'mother_id' => 'nullable|exists:family_members,id',
            'father_id' => 'nullable|exists:family_members,id',
            'spouse_id' => 'nullable|exists:family_members,id',
        ]);

        $member = FamilyMember::findOrFail($id);
        $member->update($request->all());

        return redirect()->route('admin.members.index')->with('success', 'تم تحديث معلومات العضو بنجاح');
    }

    public function memberCreate(Request $request)
    {
        $potentialParents = FamilyMember::all();
        $potentialSpouses = FamilyMember::all();
        $parentId = $request->get('parent_id');
        $parent = null;
        
        if ($parentId) {
            $parent = FamilyMember::find($parentId);
        }
        
        return view('admin.members.create', compact('potentialParents', 'potentialSpouses', 'parent'));
    }

    public function memberStore(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'maiden_name' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female',
            'address' => 'nullable|array',
            'life_description' => 'nullable|string',
            'is_alive' => 'boolean',
            'mother_id' => 'nullable|exists:family_members,id',
            'father_id' => 'nullable|exists:family_members,id',
            'spouse_id' => 'nullable|exists:family_members,id',
        ]);

        FamilyMember::create($request->all());

        $message = 'تم إضافة العضو الجديد بنجاح';
        if ($request->filled('father_id') || $request->filled('mother_id')) {
            $message = 'تم إضافة الابن/الابنة بنجاح';
        }

        return redirect()->route('admin.members.index')->with('success', $message);
    }

    public function memberDelete($id)
    {
        $member = FamilyMember::findOrFail($id);
        $member->delete();

        return redirect()->back()->with('success', 'تم حذف العضو بنجاح');
    }

    // User Management
    public function usersIndex()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function userEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function userUpdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,customer',
            'password' => 'nullable|string|min:6',
        ]);

        $user = User::findOrFail($id);
        $data = $request->only(['name', 'email', 'role']);
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'تم تحديث معلومات المستخدم بنجاح');
    }

    public function userCreate()
    {
        return view('admin.users.create');
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,customer',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'تم إضافة المستخدم الجديد بنجاح');
    }

    public function userDelete($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'لا يمكنك حذف حسابك الخاص');
        }

        $user->delete();

        return redirect()->back()->with('success', 'تم حذف المستخدم بنجاح');
    }
} 