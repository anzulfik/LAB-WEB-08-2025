@extends('layouts.app')

@section('title', 'Fish Database - Fish It Roblox')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="bi bi-database"></i> Fish Database</h4>
        <a href="{{ route('fishes.create') }}" class="btn btn-light btn-custom">
            <i class="bi bi-plus-circle"></i> Tambah Ikan
        </a>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form method="GET" action="{{ route('fishes.index') }}" class="mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Filter berdasarkan Rarity</label>
                    <select name="rarity" class="form-select">
                        <option value="">All Rarities</option>
                        <option value="Common" {{ request('rarity') == 'Common' ? 'selected' : '' }}>Common</option>
                        <option value="Uncommon" {{ request('rarity') == 'Uncommon' ? 'selected' : '' }}>Uncommon</option>
                        <option value="Rare" {{ request('rarity') == 'Rare' ? 'selected' : '' }}>Rare</option>
                        <option value="Epic" {{ request('rarity') == 'Epic' ? 'selected' : '' }}>Epic</option>
                        <option value="Legendary" {{ request('rarity') == 'Legendary' ? 'selected' : '' }}>Legendary</option>
                        <option value="Mythic" {{ request('rarity') == 'Mythic' ? 'selected' : '' }}>Mythic</option>
                        <option value="Secret" {{ request('rarity') == 'Secret' ? 'selected' : '' }}>Secret</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Cari Ikan Berdasarkan Nama</label>
                    <input type="text" name="search" class="form-control" placeholder="Cari ikan berdasarkan nama..." value="{{ request('search') }}">
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                    <a href="{{ route('fishes.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                </div>
            </div>
        </form>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Name</th>
                        <th>Rarity</th>
                        <th>Weight Range (kg)</th>
                        <th>Price/kg</th>
                        <th>Catch Rate</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($fishes as $fish)
                    <tr>
                        {{-- <td>{{ $fish->id }}</td> --}}
                        <td><strong>{{ $fish->name }}</strong></td>
                        <td>
                            <span class="rarity-badge rarity-{{ $fish->rarity }}">
                                {{ $fish->rarity }}
                            </span>
                        </td>
                        <td>{{ $fish->base_weight_min }} - {{ $fish->base_weight_max }} kg</td>
                        <td>{{ number_format($fish->sell_price_per_kg) }} Coins</td>
                        <td>{{ $fish->catch_probability }}%</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('fishes.show', $fish->id) }}" class="btn btn-sm btn-info" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('fishes.edit', $fish->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('fishes.destroy', $fish->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this fish?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted">Tidak ada ikan yang tersedia di database.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $fishes->links() }}
        </div>
    </div>
</div>
@endsection