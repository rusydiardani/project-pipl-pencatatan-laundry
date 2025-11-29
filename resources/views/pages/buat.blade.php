@extends('layouts.app')
@section('title', 'Buat Transaksi')

@section('content')
<div class="container-fluid px-4">
    <!-- Header -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin:2rem 0 1.5rem;">
        <div>
            <h1 style="font-size:28px; font-weight:700; margin:0 0 0.375rem; color:var(--gray-900); letter-spacing:-0.3px;">
                Buat Transaksi Baru
            </h1>
            <p style="color:var(--text-secondary); margin:0; font-size:14px; font-weight:500;">
                Tambahkan transaksi dengan multi-tab untuk efisiensi
            </p>
        </div>
        <div>
            <a href="{{ route('list.page') }}" class="btn" style="height:40px; padding:0 1.5rem; background:var(--gray-100); border:1px solid var(--border);">
                <i class="fas fa-arrow-left"></i> Kembali ke List
            </a>
        </div>
    </div>

    <!-- Tab Bar -->
    <div class="card" style="box-shadow:var(--shadow-sm); border-radius:var(--radius-lg) var(--radius-lg) 0 0; border:1px solid var(--border); border-bottom:none; padding:1rem 1.5rem; background:var(--gray-50);">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <div id="tab-container" style="display:flex; gap:0.5rem; flex:1;"></div>
            <div style="display:flex; gap:0.5rem;">
                <button class="btn btn-sm btn-success" id="btn-add-tab" style="height:36px; padding:0 1rem;">
                    <i class="fas fa-plus"></i> Tab Baru
                </button>
                <button class="btn btn-sm btn-danger" id="btn-remove-tab" style="height:36px; padding:0 1rem;">
                    <i class="fas fa-times"></i> Hapus Tab
                </button>
            </div>
        </div>
    </div>

    <!-- Tab Contents Container -->
    <div id="tab-contents" class="card" style="box-shadow:var(--shadow-sm); border-radius:0 0 var(--radius-lg) var(--radius-lg); border:1px solid var(--border); border-top:none; padding:2rem; background:white; min-height:600px;">
        <!-- Tabs will be inserted here -->
    </div>

    <!-- Submit Actions -->
    <div style="display:flex; justify-content:space-between; margin-top:1.5rem; padding-top:1.5rem; border-top:1px solid var(--border);">
        <a href="{{ route('list.page') }}" class="btn" style="height:48px; padding:0 2rem; background:var(--gray-100); border:1px solid var(--border);">
            <i class="fas fa-times"></i> Batal
        </a>
        <button class="btn btn-primary" id="btn-proses" style="height:48px; padding:0 2.5rem; font-size:16px;">
            <i class="fas fa-check-circle"></i> Proses Semua Transaksi
        </button>
    </div>
</div>

<!-- Template for Tab Content (Hidden) -->
<template id="tab-template">
    <div class="tab-content" style="display:none;">
        <!-- Client Info -->
        <div style="background:var(--gray-50); border-radius:var(--radius-lg); padding:1.5rem; margin-bottom:1.5rem;">
            <h3 style="font-size:16px; font-weight:700; margin:0 0 1rem; color:var(--gray-900);">
                <i class="fas fa-user" style="color:var(--primary);"></i> Informasi Pelanggan
            </h3>
            <div class="row">
                <div class="col-md-4" style="margin-bottom:1rem;">
                    <label style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">Ref No</label>
                    <input type="text" class="input ref_no" placeholder="Auto-generate" readonly style="width:100%; background:var(--gray-100);">
                </div>
                <div class="col-md-4" style="margin-bottom:1rem;">
                    <label style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">Created By</label>
                    <input type="text" class="input created_by" value="{{ auth()->user()->username ?? 'Admin' }}" readonly style="width:100%; background:var(--gray-100);">
                </div>
                <div class="col-md-4" style="margin-bottom:1rem;">
                    <label style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">Nama Pelanggan *</label>
                    <div class="client-container" style="position:relative;">
                        <input type="text" class="input client-search" placeholder="Ketik nama pelanggan..." autocomplete="off" style="width:100%;">
                        <input type="hidden" class="client_id">
                        <div class="client-dropdown" style="position:absolute; top:calc(100% + 4px); left:0; width:100%; max-height:250px; overflow-y:auto; background:white; border:1px solid var(--border); border-radius:var(--radius-md); z-index:1000; display:none; box-shadow:var(--shadow-lg);"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Service Selection -->
        <div style="background:white; border:1px solid var(--border); border-radius:var(--radius-lg); padding:1.5rem; margin-bottom:1.5rem;">
            <h3 style="font-size:16px; font-weight:700; margin:0 0 1rem; color:var(--gray-900);">
                <i class="fas fa-concierge-bell" style="color:var(--success);"></i> Pilih Jasa/Service
            </h3>
            <div class="row">
                <div class="col-md-6" style="margin-bottom:1rem;">
                    <label style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">Nama Jasa *</label>
                    <select class="input product-select" style="width:100%;">
                        <option value="" disabled selected>-- Pilih Jasa --</option>
                        @foreach(\App\Models\Service::where('available', true)->get() as $service)
                            <option value="{{ $service->id }}" data-price="{{ $service->price }}" data-type="service">
                                {{ $service->name }} - Rp {{ number_format($service->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" class="product_id">
                    <input type="hidden" class="product_type">
                </div>
                <div class="col-md-2" style="margin-bottom:1rem;">
                    <label style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">Berat (Kg) *</label>
                    <input type="number" class="input weight" step="0.1" min="0.1" value="1" style="width:100%;">
                </div>
                <div class="col-md-2" style="margin-bottom:1rem;">
                    <label style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">Harga/Kg</label>
                    <input type="number" class="input price" readonly style="width:100%; background:var(--gray-100);">
                </div>
                <div class="col-md-2" style="margin-bottom:1rem;">
                    <label style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">Subtotal</label>
                    <input type="number" class="input subtotal" readonly style="width:100%; background:var(--gray-100); font-weight:700; color:var(--success);">
                </div>
            </div>
            <div class="row schedule-fields" style="display:none;">
                <div class="col-md-6" style="margin-bottom:1rem;">
                    <label style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">Tanggal Jadwal *</label>
                    <input type="date" class="input scheduled_date" style="width:100%;">
                </div>
                <div class="col-md-6" style="margin-bottom:1rem;">
                    <label style="display:block; font-size:13px; font-weight:600; color:var(--gray-700); margin-bottom:0.5rem;">Jam Jadwal *</label>
                    <input type="time" class="input scheduled_time" style="width:100%;">
                </div>
            </div>
            <button type="button" class="btn btn-primary btn-add-item" style="width:100%; height:42px; margin-top:0.5rem;">
                <i class="fas fa-plus-circle"></i> Tambah ke Ringkasan
            </button>
        </div>

        <!-- Summary Table -->
        <div style="background:white; border:1px solid var(--border); border-radius:var(--radius-lg); padding:1.5rem;">
            <h3 style="font-size:16px; font-weight:700; margin:0 0 1rem; color:var(--gray-900);">
                <i class="fas fa-receipt" style="color:var(--warning);"></i> Ringkasan Transaksi
            </h3>
            <div class="table-responsive">
                <table class="table" style="margin:0;">
                    <thead style="background:var(--gray-50);">
                        <tr>
                            <th style="padding:0.875rem; font-size:12px; text-transform:uppercase; color:var(--gray-600);">Jasa</th>
                            <th style="padding:0.875rem; font-size:12px; text-transform:uppercase; color:var(--gray-600);">Berat</th>
                            <th style="padding:0.875rem; font-size:12px; text-transform:uppercase; color:var(--gray-600);">Harga</th>
                            <th style="padding:0.875rem; font-size:12px; text-transform:uppercase; color:var(--gray-600);">Subtotal</th>
                            <th style="padding:0.875rem; font-size:12px; text-transform:uppercase; color:var(--gray-600); width:80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="summary-body">
                        <tr class="empty-row">
                            <td colspan="5" style="padding:2rem; text-align:center; color:var(--text-secondary);">
                                <i class="fas fa-inbox" style="font-size:36px; opacity:0.3; display:block; margin-bottom:0.5rem;"></i>
                                Belum ada item. Tambahkan jasa di atas.
                            </td>
                        </tr>
                    </tbody>
                    <tfoot style="background:var(--gray-50); font-weight:700;">
                        <tr>
                            <td colspan="3" style="padding:1rem; text-align:right; font-size:16px;">TOTAL:</td>
                            <td class="total-amount" style="padding:1rem; color:var(--success); font-size:18px;">Rp 0</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</template>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
document.addEventListener('DOMContentLoaded', () => {
    let tabCounter = 0;
    const tabsContainer = document.getElementById('tab-container');
    const contentsContainer = document.getElementById('tab-contents');
    const template = document.getElementById('tab-template');

    // Create initial tab
    createTab();

    // Add Tab Button
    document.getElementById('btn-add-tab').addEventListener('click', createTab);

    // Remove Tab Button  
    document.getElementById('btn-remove-tab').addEventListener('click', () => {
        if (tabCounter <= 1) {
            alert('Minimal harus ada 1 tab!');
            return;
        }
        const activeTabs = document.querySelectorAll('.tab-btn');
        const lastTab = activeTabs[activeTabs.length - 1];
        const tabId = lastTab.dataset.tab;
        
        lastTab.remove();
        document.querySelector(`.tab-content[data-tab="${tabId}"]`).remove();
        tabCounter--;
        
        // Activate previous tab
        if (activeTabs.length > 1) {
            activeTabs[activeTabs.length - 2].click();
        }
    });

    // Expose items to DOM for collection
    function createTab() {
        tabCounter++;
        const tabId = `tab-${tabCounter}`;

        // Create tab button
        const tabBtn = document.createElement('button');
        tabBtn.className = 'tab-btn';
        tabBtn.dataset.tab = tabId;
        tabBtn.innerHTML = `<i class="fas fa-file-invoice"></i> Transaksi ${tabCounter}`;
        tabBtn.style.cssText = 'padding:0.625rem 1.25rem; border:none; background:white; border-radius:var(--radius-md); cursor:pointer; font-weight:600; font-size:13px; color:var(--gray-700); transition:all 0.2s;';
        
        tabBtn.addEventListener('click', () => switchTab(tabId));
        tabsContainer.appendChild(tabBtn);

        // Create tab content from template
        const content = template.content.cloneNode(true).querySelector('.tab-content');
        content.dataset.tab = tabId;
        contentsContainer.appendChild(content);

        // Initialize autocomplete for this tab
        initializeAutocomplete(content);

        // Switch to new tab
        switchTab(tabId);
    }

    function switchTab(tabId) {
        // Update buttons
        document.querySelectorAll('.tab-btn').forEach(btn => {
            if (btn.dataset.tab === tabId) {
                btn.style.background = 'var(--primary)';
                btn.style.color = 'white';
                btn.style.boxShadow = 'var(--shadow-sm)';
            } else {
                btn.style.background = 'white';
                btn.style.color = 'var(--gray-700)';
                btn.style.boxShadow = 'none';
            }
        });

        // Update content
        document.querySelectorAll('.tab-content').forEach(content => {
            content.style.display = content.dataset.tab === tabId ? 'block' : 'none';
        });
    }

    function initializeAutocomplete(tabContent) {
        // Customer Search
        const clientInput = tabContent.querySelector('.client-search');
        const clientDropdown = tabContent.querySelector('.client-dropdown');
        const clientIdInput = tabContent.querySelector('.client_id');

        clientInput.addEventListener('input', async (e) => {
            const query = e.target.value.trim();
            if (query.length < 2) {
                clientDropdown.style.display = 'none';
                return;
            }

            // For now, mock data - replace with actual API call
            const mockCustomers = [
                { id: 1, name: 'John Doe', phone: '08123456789' },
                { id: 2, name: 'Jane Smith', phone: '08129876543' }
            ].filter(c => c.name.toLowerCase().includes(query.toLowerCase()));

            clientDropdown.innerHTML = mockCustomers.map(customer => `
                <div class="dropdown-item" data-id="${customer.id}" data-name="${customer.name}" style="padding:0.75rem 1rem; cursor:pointer; border-bottom:1px solid var(--gray-100); transition:background 0.2s;" onmouseover="this.style.background='var(--gray-50)'" onmouseout="this.style.background='white'">
                    <div style="font-weight:600; color:var(--gray-900); margin-bottom:0.25rem;">${customer.name}</div>
                    <div style="font-size:12px; color:var(--text-secondary);">${customer.phone}</div>
                </div>
            `).join('');

            clientDropdown.querySelectorAll('.dropdown-item').forEach(item => {
                item.addEventListener('click', () => {
                    clientInput.value = item.dataset.name;
                    clientIdInput.value = item.dataset.id;
                    clientDropdown.style.display = 'none';
                });
            });

            clientDropdown.style.display = mockCustomers.length ? 'block' : 'none';
        });

        // Service/Product Select
        const productSelect = tabContent.querySelector('.product-select');
        const productIdInput = tabContent.querySelector('.product_id');
        const productTypeInput = tabContent.querySelector('.product_type');
        const priceInput = tabContent.querySelector('.price');
        const weightInput = tabContent.querySelector('.weight');
        const subtotalInput = tabContent.querySelector('.subtotal');
        const scheduleFields = tabContent.querySelector('.schedule-fields');

        productSelect.addEventListener('change', (e) => {
            const selectedOption = e.target.options[e.target.selectedIndex];
            
            if (!selectedOption.value) return;

            const productId = selectedOption.value;
            const price = selectedOption.dataset.price;
            const type = selectedOption.dataset.type;

            productIdInput.value = productId;
            productTypeInput.value = type;
            priceInput.value = price;

            // Show schedule fields if service
            if (type === 'service') {
                scheduleFields.style.display = 'flex';
            } else {
                scheduleFields.style.display = 'none';
            }

            // Calculate subtotal
            const weight = parseFloat(weightInput.value) || 1;
            subtotalInput.value = (weight * parseFloat(price)).toFixed(0);
        });

        // Weight change recalculates subtotal
        weightInput.addEventListener('input', () => {
            const weight = parseFloat(weightInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            subtotalInput.value = (weight * price).toFixed(0);
        });
        
        // Add Item Button
        const btnAddItem = tabContent.querySelector('.btn-add-item');
        const summaryBody = tabContent.querySelector('.summary-body');
        const totalAmount = tabContent.querySelector('.total-amount');
        
        // Store items on the DOM element for easy access
        tabContent.items = []; 

        btnAddItem.addEventListener('click', () => {
            // ... (keep existing validation) ...
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const productName = selectedOption ? selectedOption.text.split(' - ')[0] : '';
            const productId = productIdInput.value;
            const productType = productTypeInput.value;
            const weight = parseFloat(weightInput.value);
            const price = parseFloat(priceInput.value);
            const subtotal = parseFloat(subtotalInput.value);
            
            // Schedule data
            const scheduledDate = tabContent.querySelector('.scheduled_date').value;
            const scheduledTime = tabContent.querySelector('.scheduled_time').value;

            if (!productId || !productName) {
                alert('Pilih jasa terlebih dahulu!');
                return;
            }

            if (!weight || weight <= 0) {
                alert('Berat harus lebih dari 0!');
                return;
            }
            
            if (productType === 'service' && (!scheduledDate || !scheduledTime)) {
                alert('Jadwal harus diisi untuk layanan service!');
                return;
            }

            // Add to items array attached to DOM
            tabContent.items.push({ 
                product_name: productName, 
                product_id: productId, 
                product_type: productType,
                weight: weight, 
                price: price, 
                subtotal: subtotal,
                scheduled_date: scheduledDate,
                scheduled_time: scheduledTime,
                status: 'ON PROCESS'
            });

            // Re-render table
            renderSummaryTable();

            // Reset form
            productSelect.value = '';
            productIdInput.value = '';
            productTypeInput.value = '';
            priceInput.value = '';
            weightInput.value = '1';
            subtotalInput.value = '';
            scheduleFields.style.display = 'none';
        });

        function renderSummaryTable() {
            const items = tabContent.items;
            if (items.length === 0) {
                summaryBody.innerHTML = `
                    <tr class="empty-row">
                        <td colspan="5" style="padding:2rem; text-align:center; color:var(--text-secondary);">
                            <i class="fas fa-inbox" style="font-size:36px; opacity:0.3; display:block; margin-bottom:0.5rem;"></i>
                            Belum ada item. Tambahkan jasa di atas.
                        </td>
                    </tr>
                `;
                totalAmount.textContent = 'Rp 0';
                return;
            }

            summaryBody.innerHTML = items.map((item, index) => `
                <tr>
                    <td style="padding:0.875rem; font-weight:600;">${item.product_name}</td>
                    <td style="padding:0.875rem;">${item.weight} kg</td>
                    <td style="padding:0.875rem;">Rp ${item.price.toLocaleString('id-ID')}</td>
                    <td style="padding:0.875rem; font-weight:700; color:var(--success);">Rp ${item.subtotal.toLocaleString('id-ID')}</td>
                    <td style="padding:0.875rem;">
                        <button onclick="removeItem('${tabContent.dataset.tab}', ${index})" class="btn btn-sm" style="height:32px; padding:0 0.75rem; background:var(--danger-pale); color:var(--danger); border:1px solid var(--danger);">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');

            const total = items.reduce((sum, item) => sum + item.subtotal, 0);
            totalAmount.textContent = `Rp ${total.toLocaleString('id-ID')}`;
        }
        
        // Expose render function for global removeItem to call
        tabContent.renderSummaryTable = renderSummaryTable;
    }

    // Global removeItem function
    window.removeItem = (tabId, index) => {
        const tabContent = document.querySelector(`.tab-content[data-tab="${tabId}"]`);
        if (tabContent && tabContent.items) {
            tabContent.items.splice(index, 1);
            tabContent.renderSummaryTable();
        }
    };

    // Process All Transactions
    document.getElementById('btn-proses').addEventListener('click', async () => {
        const tabs = document.querySelectorAll('.tab-content');
        let allData = [];
        let hasError = false;

        tabs.forEach((tab, index) => {
            const clientName = tab.querySelector('.client-search').value;
            const clientId = tab.querySelector('.client_id').value;
            const items = tab.items || [];

            if (!clientName) {
                Toast.error(`Tab ${index + 1}: Nama pelanggan wajib diisi!`);
                hasError = true;
                return;
            }

            if (items.length === 0) {
                Toast.error(`Tab ${index + 1}: Belum ada item transaksi!`);
                hasError = true;
                return;
            }

            // Construct payload for this transaction
            allData.push({
                client_name: clientName,
                customer_id: clientId || null,
                items: items
            });
        });

        if (hasError || allData.length === 0) return;

        // Disable button
        const btnProses = document.getElementById('btn-proses');
        const originalText = btnProses.innerHTML;
        btnProses.disabled = true;
        btnProses.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

        try {
            // Send requests sequentially or parallel. 
            // Since our backend endpoint creates ONE transaction (ref_no) per request (or per loop in store),
            // let's check TransactionController@store again.
            // It accepts "items" array and loops through them creating one transaction row per item.
            // Wait, the controller structure:
            // foreach ($validated['items'] as $item) { Transaction::create(...) }
            // So one request can handle multiple items for ONE client.
            // But here we have multiple TABS, each tab is a DIFFERENT client (potentially).
            // So we need to send ONE request PER TAB.

            for (const data of allData) {
                const response = await fetch('{{ route("transactions.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (!response.ok) {
                    throw new Error(result.message || 'Gagal menyimpan transaksi');
                }
            }

            // Success
            Toast.success('Semua transaksi berhasil dibuat!');
            setTimeout(() => {
                window.location.href = '{{ route("list.page") }}';
            }, 1000);

        } catch (error) {
            console.error(error);
            Toast.error(error.message || 'Terjadi kesalahan saat memproses transaksi.');
            btnProses.disabled = false;
            btnProses.innerHTML = originalText;
        }
    });
});
</script>

<style>
.tab-btn {
    transition: all 0.2s ease;
}
.tab-btn:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md) !important;
}
</style>
@endsection
