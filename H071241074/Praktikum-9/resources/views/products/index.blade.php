@extends('layouts.app')
@section('title', 'Daftar Produk')

@section('content')
<div class="min-h-screen bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/Produk.png') }}');">
    <section class="pt-36 pb-28 relative max-w-5xl mx-auto px-3">
        <div class="glass-container rounded-2xl shadow-xl">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 px-6 py-5 border-b border-gray-200">
                <h2 class="text-3xl font-bold text-blue-700">Daftar Produk</h2>

                <a href="{{ route('products.create') }}"
                    class="gradient-btn hover:brightness-110 text-white px-6 py-2.5 rounded-2xl font-semibold shadow-md whitespace-nowrap">
                    + Tambah Produk
                </a>
            </div>

            <table class="min-w-full border-collapse">
                <thead class="bg-white/70 text-gray-800 border-b border-gray-300">
                    <tr>
                        <th class="py-3 px-4 text-left font-semibold uppercase text-sm">Nama</th>
                        <th class="py-3 px-4 text-left font-semibold uppercase text-sm">Kategori</th>
                        <th class="py-3 px-4 text-right font-semibold uppercase text-sm">Harga</th>
                        <th class="py-3 px-4 text-center font-semibold uppercase text-sm">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200/70 bg-white/60">
                    @foreach($products as $p)
                    <tr class="hoverable">
                        <td class="py-3 px-4 font-medium text-gray-800">{{ $p->name }}</td>
                        <td class="py-3 px-4 text-gray-700">{{ $p->category->name ?? '-' }}</td>
                        <td class="py-3 px-4 text-right text-green-700 font-semibold">
                            Rp {{ number_format($p->price, 2, ',', '.') }}
                        </td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex justify-center gap-2">

                                <a href="{{ route('products.show', $p) }}"
                                    class="gradient-btn text-sm font-medium px-4 py-2 rounded-2xl shadow-md">
                                    Lihat
                                </a>

                                <a href="{{ route('products.edit', $p) }}"
                                    class="gradient-btn text-white text-sm font-medium px-4 py-2 rounded-2xl shadow-md hover:brightness-110">
                                    Edit
                                </a>

                                <x-delete :action="route('products.destroy', $p)" />
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="p-4 border-t border-gray-200 bg-white/50 text-center">
                {{ $products->links() }}
            </div>

        </div>
    </section>
</div>
@endsection
