<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $query = User::with('branch');
        
        if ($user->role !== 'owner') {
            $query->where('branch_id', $user->branch_id);
        }
        
        $users = $query->get();
        
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager'])) {
            abort(403, 'Unauthorized action.');
        }

        $user = auth()->user();
        $branches = ($user->role === 'owner') ? Branch::all() : Branch::where('id', $user->branch_id)->get();
        return view('users.create', compact('branches'));
    }

    public function store(Request $request)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'branch_id' => 'nullable|exists:branches,id', 
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:owner,manager,supervisor,cashier,warehouse',
        ]);

        if ($request->role !== 'owner' && !$request->branch_id) {
            return back()->withErrors(['branch_id' => 'Cabang wajib dipilih untuk role ini'])->withInput();
        }

        User::create([
            'branch_id' => $request->role === 'owner' ? null : $request->branch_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager'])) {
            abort(403, 'Unauthorized action.');
        }

        $currentUser = auth()->user();
        $branches = ($currentUser->role === 'owner') ? Branch::all() : Branch::where('id', $currentUser->branch_id)->get();
        return view('users.edit', compact('user', 'branches'));
    }

    public function update(Request $request, User $user)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager'])) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'branch_id' => 'nullable|exists:branches,id', 
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:owner,manager,supervisor,cashier,warehouse',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->role === 'owner') {
            $data['branch_id'] = null;
        } else {
            if (!$request->branch_id) {
                return back()->withErrors(['branch_id' => 'Cabang wajib dipilih untuk role ini'])->withInput();
            }
            $data['branch_id'] = $request->branch_id;
        }

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6',
            ]);

            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        if (!in_array(auth()->user()->role, ['owner', 'manager'])) {
            abort(403, 'Unauthorized action.');
        }

        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Tidak bisa menghapus akun sendiri']);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}