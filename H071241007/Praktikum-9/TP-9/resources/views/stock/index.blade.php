@extends('layouts.app')

@section('title', 'Manajemen Stok')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        {{-- form trasfer --}}
        <div class="md:col-span-1">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Transfer Stok</h3>
            
            <form action="{{ route('stock.transfer') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    {{-- Pilih Gudang --}}
                    <div>
                        <label for="warehouse_id_transfer" class="block text-sm font-medium text-gray-700">Pilih Gudang</label>
                        <select name="warehouse_id" id="warehouse_id_transfer" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">-- Pilih Gudang --</option>
                            @foreach ($warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}" {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pilih Produk --}}
                    <div>
                        <label for="product_id" class="block text-sm font-medium text-gray-700">Pilih Produk</label>
                        <select name="product_id" id="product_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jumlah Stok --}}
                    <div>
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Jumlah (+/-) </label>
                        <input type="number" name="quantity" id="quantity" value="{{ old('quantity') }}" required
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                               placeholder="Contoh: 10 (masuk) atau -5 (keluar)">
                        <p class="mt-1 text-xs text-gray-500">Gunakan nilai positif untuk stok masuk, negatif untuk keluar.</p>
                    </div>

                    {{-- Tombol Submit --}}
                    <div>
                        <button type="submit" class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Proses Transfer
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- LIST STOK --}}
        <div class="md:col-span-2">
            
            {{-- Form Filter Gudang --}}
            <form action="{{ route('stock.index') }}" method="GET" class="mb-4">
                <div class="flex items-end space-x-2">
                    <div class="flex-grow">
                        <label for="warehouse_id_filter" class="block text-sm font-medium text-gray-700">Filter Gudang</label>
                        <select name="warehouse_id" id="warehouse_id_filter"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="">-- Pilih Gudang untuk Menampilkan Stok --</option>
                            @foreach ($warehouses as $warehouse)
                                {{-- $selectedWarehouseId didapat dari controller --}}
                                <option value="{{ $warehouse->id }}" {{ $selectedWarehouseId == $warehouse->id ? 'selected' : '' }}>
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                        Tampilkan
                    </button>
                </div>
            </form>

            {{-- Tabel List Stok --}}
            <div class="overflow-x-auto shadow-md rounded-lg border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Produk</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Stok </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($stocks as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->id }}</td>
                                <td class="px-6 py-4 whitespace-nowring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150ap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-bold">{{ $product->pivot->quantity }} pcs</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-sm text-gray-500">
                                    {{ $selectedWarehouseId ? 'Tidak ada stok produk di gudang ini.' : 'Silakan pilih gudang untuk melihat stok.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection