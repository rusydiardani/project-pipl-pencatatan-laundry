<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;

class CustomerRepository
{
    public function create(array $data): Customer
    {
        return Customer::create($data);
    }

    public function findById(int $id): ?Customer
    {
        return Customer::find($id);
    }
    
    public function findByPhone(string $phone): ?Customer
    {
        return Customer::where('phone', $phone)->first();
    }
    
    public function getAll(): Collection
    {
        return Customer::orderBy('name')->get();
    }

    public function getWithTransactions(int $id): ?Customer
    {
        return Customer::with('transactions')->find($id);
    }

    public function search(string $query): Collection
    {
        return Customer::where('name', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orderBy('name')
            ->get();
    }
    public function getPaginated(int $perPage = 10)
    {
        return Customer::orderBy('name')->paginate($perPage);
    }

    public function searchPaginated(string $query, int $perPage = 10)
    {
        return Customer::where('name', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orderBy('name')
            ->paginate($perPage);
    }
}
