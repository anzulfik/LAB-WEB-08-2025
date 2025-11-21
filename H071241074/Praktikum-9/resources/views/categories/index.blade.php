@extends('layouts.app')
@section('title', 'Daftar Kategori')
@section('content')

<section class="relative w-full min-h-screen pt-32 bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/Kategori.png') }}');">
    <div class="max-w-5xl mx-auto px-3 pb-28">
        <div class="glass-container rounded-2xl shadow-xl">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 px-6 py-5 border-b border-gray-200">
            <h2 class="text-3xl font-bold text-blue-700">Daftar Kategori</h2>

            <a href="{{ route('categories.create') }}"
               class="gradient-btn text-white px-6 py-2.5 rounded-2xl font-semibold shadow-md whitespace-nowrap hover:brightness-110">
                + Tambah Kategori
            </a>
        </div>

        <table class="min-w-full border-collapse">
            <thead class="bg-white/70 text-gray-800 border-b border-gray-300">
                <tr>
                    <th class="py-3 px-4 text-left font-semibold uppercase text-sm">Nama</th>
                    <th class="py-3 px-4 text-left font-semibold uppercase text-sm">Deskripsi</th>
                    <th class="py-3 px-4 text-center font-semibold uppercase text-sm">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200/70 bg-white/60">
                @forelse($categories as $cat)
                <tr class="hoverable">
                    <td class="py-3 px-4 font-medium text-gray-800">{{ $cat->name }}</td>
                    <td class="py-3 px-4 text-gray-700">{{ $cat->description ?: '-' }}</td>
                    <td class="py-3 px-4 text-center">
                        <div class="flex justify-center gap-2">

                            <a href="{{ route('categories.show', $cat) }}"
                               class="gradient-btn text-sm font-medium px-4 py-2 rounded-2xl shadow-md">
                                Lihat
                            </a>

                            <a href="{{ route('categories.edit', $cat) }}"
                               class="gradient-btn text-white text-sm font-medium px-4 py-2 rounded-2xl shadow-md hover:brightness-110">
                                Edit
                            </a>

                            <x-delete :action="route('categories.destroy', $cat)" />

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="text-center text-gray-500 py-6">
                        Belum ada kategori.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t border-gray-200 bg-white/50 text-center">
            {{ $categories->links() }}
        </div>

        </div>
    </div>
</section>
@endsection
