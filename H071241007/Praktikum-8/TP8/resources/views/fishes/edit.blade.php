@extends('layouts.app')

@section('title', 'Edit Fish - Fish It Roblox')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0"><i class="bi bi-pencil"></i> Edit Ikan: {{ $fish->name }}</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('fishes.update', $fish->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Fish Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Ikan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $fish->name) }}" 
                               placeholder="Contoh: Tuna" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Rarity -->
                    <div class="mb-3">
                        <label for="rarity" class="form-label">Rarity <span class="text-danger">*</span></label>
                        <select class="form-select @error('rarity') is-invalid @enderror" 
                                id="rarity" name="rarity" required>
                            <option value="">Select Rarity</option>
                            <option value="Common" {{ old('rarity', $fish->rarity) == 'Common' ? 'selected' : '' }}>Common</option>
                            <option value="Uncommon" {{ old('rarity', $fish->rarity) == 'Uncommon' ? 'selected' : '' }}>Uncommon</option>
                            <option value="Rare" {{ old('rarity', $fish->rarity) == 'Rare' ? 'selected' : '' }}>Rare</option>
                            <option value="Epic" {{ old('rarity', $fish->rarity) == 'Epic' ? 'selected' : '' }}>Epic</option>
                            <option value="Legendary" {{ old('rarity', $fish->rarity) == 'Legendary' ? 'selected' : '' }}>Legendary</option>
                            <option value="Mythic" {{ old('rarity', $fish->rarity) == 'Mythic' ? 'selected' : '' }}>Mythic</option>
                            <option value="Secret" {{ old('rarity', $fish->rarity) == 'Secret' ? 'selected' : '' }}>Secret</option>
                        </select>
                        @error('rarity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Weight Range -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="base_weight_min" class="form-label">Berat Minimum (kg) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('base_weight_min') is-invalid @enderror" 
                                   id="base_weight_min" name="base_weight_min" value="{{ old('base_weight_min', $fish->base_weight_min) }}" 
                                   placeholder="contoh: 1.50" required>
                            @error('base_weight_min')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="base_weight_max" class="form-label">Berat Maximum (kg) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control @error('base_weight_max') is-invalid @enderror" 
                                   id="base_weight_max" name="base_weight_max" value="{{ old('base_weight_max', $fish->base_weight_max) }}" 
                                   placeholder="contoh: 5.00" required>
                            @error('base_weight_max')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sell Price -->
                    <div class="mb-3">
                        <label for="sell_price_per_kg" class="form-label">Harga Jual Per KG(Coins) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('sell_price_per_kg') is-invalid @enderror" 
                               id="sell_price_per_kg" name="sell_price_per_kg" value="{{ old('sell_price_per_kg', $fish->sell_price_per_kg) }}" 
                               placeholder="Contoh: 1000" required>
                        @error('sell_price_per_kg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Catch Probability -->
                    <div class="mb-3">
                        <label for="catch_probability" class="form-label">Probabilitas Ditangkap (%) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0.01" max="100" 
                               class="form-control @error('catch_probability') is-invalid @enderror" 
                               id="catch_probability" name="catch_probability" value="{{ old('catch_probability', $fish->catch_probability) }}" 
                               placeholder="contoh: 10%" required>
                        <small class="text-muted">Must be between 0.01% and 100%</small>
                        @error('catch_probability')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="4" 
                                  placeholder="Masukkan deskripsi ikan (optional)">{{ old('description', $fish->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('fishes.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-warning btn-custom">
                            <i class="bi bi-check-circle"></i> Update Ikan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection