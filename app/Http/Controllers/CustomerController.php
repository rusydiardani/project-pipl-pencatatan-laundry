<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Repositories\CustomerRepository;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerRepo;

    public function __construct(CustomerRepository $customerRepo)
    {
        $this->customerRepo = $customerRepo;
    }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        if ($request->filled('search')) {
            $customers = $this->customerRepo->searchPaginated($request->search, $perPage);
        } else {
            $customers = $this->customerRepo->getPaginated($perPage);
        }

        if ($request->wantsJson()) {
            return response()->json($customers);
        }

        return view('pages.customers.index', compact('customers'));
    }

    public function create()
    {
        return view('pages.customers.create');
    }

    public function store(StoreCustomerRequest $request)
    {
        $this->customerRepo->create($request->validated());
        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil ditambahkan');
    }

    public function edit(Customer $customer)
    {
        return view('pages.customers.edit', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        return redirect()->route('customers.index')->with('success', 'Data pelanggan berhasil diperbarui');
    }

    public function destroy(Customer $customer)
    {
        // Cek apakah punya transaksi
        if ($customer->transactions()->exists()) {
            return back()->with('error', 'Tidak dapat menghapus pelanggan yang memiliki riwayat transaksi.');
        }
        
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Pelanggan berhasil dihapus');
    }
}
