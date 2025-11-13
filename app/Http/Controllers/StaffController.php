<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::with('user')->latest()->paginate(20);
        return view('pages.staff.index', compact('staff'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('staff')->get();
        return view('pages.staff.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:staff,phone',
            'address' => 'nullable|string',
            'position' => 'required|string',
            'is_active' => 'boolean',
            'user_id' => 'nullable|exists:users,id',
        ]);

        Staff::create($validated);

        return redirect()->route('staff.index')
            ->with('success', 'Data staff berhasil ditambahkan!');
    }

    public function edit(Staff $staff)
    {
        $staff->load('user');
        $users = User::whereDoesntHave('staff')->orWhere('id', $staff->user_id)->get();
        return view('pages.staff.edit', compact('staff', 'users'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:staff,phone,' . $staff->id,
            'address' => 'nullable|string',
            'position' => 'required|string',
            'is_active' => 'boolean',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $staff->update($validated);

        return redirect()->route('staff.index')
            ->with('success', 'Data staff berhasil diperbarui!');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();

        return redirect()->route('staff.index')
            ->with('success', 'Data staff berhasil dihapus!');
    }
}
