<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $members = User::where('role', 'member')
            ->when($search, function ($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('student_id', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.members.index', compact('members', 'search'));
    }

    public function create()
    {
        return view('admin.members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'student_id' => 'nullable|string|max:50|unique:users,student_id',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,suspended',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'member';

        User::create($validated);

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show(User $member)
    {
        if ($member->role !== 'member') {
            abort(404);
        }
        
        $member->load(['borrowings.book', 'fines']);
        return view('admin.members.show', compact('member'));
    }

    public function edit(User $member)
    {
        if ($member->role !== 'member') {
            abort(404);
        }
        
        return view('admin.members.edit', compact('member'));
    }

    public function update(Request $request, User $member)
    {
        if ($member->role !== 'member') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($member->id)],
            'student_id' => ['nullable', 'string', 'max:50', Rule::unique('users')->ignore($member->id)],
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:active,suspended',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $member->update($validated);

        return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(User $member)
    {
        if ($member->role !== 'member') {
            abort(404);
        }

        if ($member->borrowings()->whereIn('status', ['pending', 'approved', 'borrowed', 'overdue', 'return_requested'])->exists()) {
            return back()->with('error', 'Tidak dapat menghapus anggota yang memiliki pinjaman aktif.');
        }
        
        $member->delete();

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
