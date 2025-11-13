<?php

namespace App\Http\Controllers;

use App\Models\LaundryItem;
use Illuminate\Http\Request;

class LaundryItemController extends Controller
{
    public function index()
    {
        $items = LaundryItem::latest()->paginate(20);
        return view('pages.laundry-items.index', compact('items'));
    }

    public function create()
    {
        return view('pages.laundry-items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_kg' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        LaundryItem::create($validated);

        return redirect()->route('laundry-items.index')
            ->with('success', 'Layanan laundry berhasil ditambahkan');
    }

    public function show(LaundryItem $laundryItem)
    {
        return view('pages.laundry-items.show', compact('laundryItem'));
    }

    public function edit(LaundryItem $laundryItem)
    {
        return view('pages.laundry-items.edit', compact('item'));
    }

    public function update(Request $request, LaundryItem $laundryItem)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_kg' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $laundryItem->update($validated);

        return redirect()->route('laundry-items.index')
            ->with('success', 'Layanan laundry berhasil diupdate');
    }

    public function destroy(LaundryItem $laundryItem)
    {
        $laundryItem->delete();

        return redirect()->route('laundry-items.index')
            ->with('success', 'Layanan laundry berhasil dihapus');
    }
}
