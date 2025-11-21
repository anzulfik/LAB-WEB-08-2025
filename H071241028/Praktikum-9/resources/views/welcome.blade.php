{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Utama')

@section('content')
<div class="space-y-6 w-full">


    {{-- Greeting & Navigasi Cepat --}}
    <div class="flex flex-col lg:flex-row justify-between lg:items-center bg-white p-5 rounded-xl shadow-sm">
        <div>
            <h2 class="text-2xl font-semibold text-gray-800" id="greeting">Selamat Datang 👋</h2>
            <p class="text-sm text-gray-500" id="dateTime">Memuat waktu...</p>
        </div>

        {{-- Tombol Navigasi --}}
        <div class="flex flex-wrap gap-2 mt-4 lg:mt-0">
            <a href="{{ route('products.index') }}" class="bg-rose-600 hover:bg-rose-700 text-white px-4 py-2 rounded-lg shadow transition">🛒 Produk</a>
            <a href="{{ route('categories.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">📦 Kategori</a>
            <a href="{{ route('warehouses.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition">🏭 Gudang</a>
            <a href="{{ route('stocks.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow transition">📊 Stok</a>
        </div>
    </div>

    {{-- Statistik Ringkas --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @php
            $cards = [
                ['label'=>'Total Produk','value'=>$totalProducts,'desc'=>'Produk aktif saat ini','icon'=>'🛒','color'=>'rose'],
                ['label'=>'Kategori','value'=>$totalCategories,'desc'=>'Kategori terdaftar','icon'=>'📦','color'=>'blue'],
                ['label'=>'Gudang','value'=>$totalWarehouses,'desc'=>'Lokasi penyimpanan','icon'=>'🏭','color'=>'green'],
                ['label'=>'Total Stok','value'=>number_format($totalStock,0,',','.'),'desc'=>'Jumlah stok tersimpan','icon'=>'📊','color'=>'purple']
            ];
        @endphp

        @foreach ($cards as $c)
        <div class="bg-white rounded-xl p-5 shadow-sm flex items-center justify-between border border-gray-100 hover:shadow-md transition">
            <div>
                <h3 class="text-sm text-gray-500 font-semibold">{{ $c['label'] }}</h3>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $c['value'] }}</p>
                <p class="text-xs text-gray-400 mt-1">{{ $c['desc'] }}</p>
            </div>
            <div class="p-3 rounded-xl bg-{{ $c['color'] }}-100">
                <span class="text-{{ $c['color'] }}-600 text-xl">{{ $c['icon'] }}</span>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Aktivitas & Grafik --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-4">
        {{-- Aktivitas Stok --}}
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 lg:col-span-2">
            <h3 class="text-lg font-semibold text-gray-700 mb-3 border-b pb-2">Aktivitas Stok Terbaru</h3>

            @if ($recentActivities->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-gray-600">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="text-left py-3 px-2">Produk</th>
                                <th class="text-left py-3 px-2">Gudang</th>
                                <th class="text-left py-3 px-2">Jumlah</th>
                                <th class="text-left py-3 px-2">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentActivities as $activity)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-2 px-2">{{ $activity->product->name ?? '-' }}</td>
                                <td class="px-2">{{ $activity->warehouse->name ?? '-' }}</td>
                                <td class="px-2 font-semibold {{ $activity->quantity >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $activity->quantity >= 0 ? '+' : '' }}{{ $activity->quantity }}
                                </td>
                                <td class="px-2">{{ $activity->created_at->format('d M Y H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500 text-center py-6">Belum ada aktivitas stok terbaru.</p>
            @endif
        </div>

        {{-- Grafik Stok --}}
        <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex flex-col justify-center">
            <h3 class="text-lg font-semibold text-gray-700 mb-4 text-center">Statistik Stok per Kategori</h3>
            <div class="h-[260px]">
                <canvas id="stockChart"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Script Tambahan --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function updateTime() {
        const now = new Date();
        const hours = now.getHours();
        const greeting =
            hours < 12 ? 'Selamat Pagi ☀️' :
            hours < 18 ? 'Selamat Siang 🌤️' :
            'Selamat Malam 🌙';

        document.getElementById('greeting').innerText = `${greeting}, {{ Auth::user()->name ?? 'User' }}!`;
        document.getElementById('dateTime').innerText = now.toLocaleString('id-ID', {
            weekday: 'long', year: 'numeric', month: 'long', day: 'numeric',
            hour: '2-digit', minute: '2-digit'
        });
    }
    setInterval(updateTime, 1000);
    updateTime();

    // Chart.js
    const ctx = document.getElementById('stockChart');
    const categoryNames = @json($categoryNames ?? []);
    const categoryStocks = @json($categoryStocks ?? []);
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: categoryNames,
            datasets: [{
                label: 'Jumlah Stok',
                data: categoryStocks,
                backgroundColor: ['#f43f5e','#3b82f6','#10b981','#8b5cf6','#f59e0b'],
                borderRadius: 8,
            }]
        },
        options: {
            maintainAspectRatio: false,
            scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } } },
            plugins: { legend: { display: false } }
        }
    });
</script>
@endsection
