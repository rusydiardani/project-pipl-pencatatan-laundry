<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Med;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Med::orderBy('name')->get();
        return view('pages.products.index', compact('products'));
    }

    public function create()
    {
        return view('pages.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Med::create($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $product = Med::findOrFail($id);
        return view('pages.products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = Med::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy($id)
    {
        $product = Med::findOrFail($id);
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }

    public function search(Request $request)
    {
        try {
            $q = $request->query('q');
            if ($q === null || $q === '') {
                return response()->json([]);
            }

            $isNumeric = ctype_digit((string)$q);

            // Services
            $servicesQuery = Service::query();
            if ($isNumeric) {
                $servicesQuery->where('id', (int)$q);
            } else {
                $servicesQuery->where('name', 'like', "%{$q}%");
            }
            $services = $servicesQuery->get(['id','name','price'])
                ->map(fn($s)=>[
                    'id'    => $s->id,
                    'name'  => $s->name,
                    'type'  => 'service',
                    'price' => $s->price,
                ])->toArray();

            // Meds
            $medsQuery = Med::query();
            if ($isNumeric) {
                $medsQuery->where('id', (int)$q);
            } else {
                $medsQuery->where('name', 'like', "%{$q}%");
            }
            $meds = $medsQuery->get(['id','name','price','stock'])
                ->map(fn($m)=>[
                    'id'    => $m->id,
                    'name'  => $m->name,
                    'type'  => 'med',
                    'price' => $m->price,
                    'stock' => $m->stock,
                ])->toArray();

            return response()->json(array_merge($services, $meds));
        } catch (\Throwable $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
