<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
       if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }

        $branches = Branch::all();
        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }
        return view('branches.create');
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'address' => 'required',
        ]);

        Branch::create($request->only(['name', 'city', 'address']));

        return redirect()->route('branches.index')->with('success', 'Cabang berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Branch $branch)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }
        return view('branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string',
        ]);

        $branch->update($request->only(['name', 'city', 'address']));

        return redirect()->route('branches.index')->with('success', 'Cabang berhasil diupdate');
    }

    public function destroy(Branch $branch)
    {
         if (auth()->user()->role !== 'owner') {
            abort(403, 'Unauthorized action.');
        }
        $branch->delete();

        return redirect()->route('branches.index')->with('success', 'Cabang berhasil dihapus');
    }
}