@extends('layouts.app')

@section('content')
<div class="mb-8">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-4xl font-bold text-white mb-2">Stok Produk per Gudang</h1>
            <div class="h-1 w-32 bg-gradient-to-r from-cyan-400 via-purple-500 to-pink-500 rounded-full"></div>
            <p class="text-gray-400 mt-3">Monitoring stok produk di semua warehouse</p>
        </div>
        
        <a href="{{ route('stocks.transferForm') }}"
           class="px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold rounded-2xl hover:shadow-[0_0_30px_rgba(34,197,94,0.6)] transition-all duration-300 transform hover:scale-105 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
            </svg>
            TRANSFER STOK
        </a>
    </div>
</div>

<div class="relative backdrop-blur-xl rounded-3xl p-8 border border-cyan-400/20" style="background: rgba(10, 14, 39, 0.1);">
    
    <!-- Decorative corners -->
    <div class="absolute -top-2 -left-2 w-16 h-16 border-t-4 border-l-4 border-cyan-400 rounded-tl-3xl opacity-50"></div>
    <div class="absolute -bottom-2 -right-2 w-16 h-16 border-b-4 border-r-4 border-pink-500 rounded-br-3xl opacity-50"></div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b-2 border-purple-500/30">
                    <th class="py-4 px-6 text-left text-cyan-300 font-bold text-sm tracking-wider">
                        PRODUK
                    </th>

                    @foreach($warehouses as $warehouse)
                        <th class="py-4 px-6 text-center text-cyan-300 font-bold text-sm tracking-wider whitespace-nowrap">
                            <div class="flex flex-col items-center gap-1">
                                <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                <span>{{ $warehouse->name }}</span>
                            </div>
                        </th>
                    @endforeach
                </tr>
            </thead>

            <tbody>
                @foreach($products as $product)
                <tr class="border-b border-purple-500/20 hover:bg-purple-500/5 transition-colors duration-200">
                    <td class="py-4 px-6 text-white font-medium">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            {{ $product->name }}
                        </div>
                    </td>

                    @foreach($warehouses as $warehouse)
                        <td class="py-4 px-6 text-center">
                            @php
                                $qty = $stockMatrix[$product->id][$warehouse->id];
                            @endphp
                            
                            <span class="inline-flex items-center justify-center min-w-[60px] px-3 py-1.5 rounded-xl font-bold text-sm
                                {{ $qty > 0 ? 'bg-green-500/20 text-green-300 border border-green-400/50' : 'bg-gray-500/20 text-gray-400 border border-gray-500/50' }}">
                                {{ $qty }}
                            </span>
                        </td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6 pt-6 border-t border-purple-500/20">
        {{ $products->links() }}
    </div>

</div>
@endsection