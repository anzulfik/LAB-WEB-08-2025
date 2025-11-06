@extends('layouts.app')

@section('title', $fish->name . ' - Fish It Roblox')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-info-circle"></i> Detail Ikan</h4>
                <span class="rarity-badge rarity-{{ $fish->rarity }}">{{ $fish->rarity }}</span>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h2 class="text-primary mb-3">{{ $fish->name }}</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="text-muted mb-2">
                                    <i class="bi bi-hash"></i> ID Ikan
                                </h6>
                                <p class="h5 mb-0">{{ $fish->id }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="text-muted mb-2">
                                    <i class="bi bi-award"></i> Rarity
                                </h6>
                                <p class="h5 mb-0">
                                    <span class="rarity-badge rarity-{{ $fish->rarity }}">{{ $fish->rarity }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="text-muted mb-2">
                                    <i class="bi bi-speedometer"></i> Range Berat
                                </h6>
                                <p class="h5 mb-0">{{ $fish->base_weight_min }} - {{ $fish->base_weight_max }} kg</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="text-muted mb-2">
                                    <i class="bi bi-coin"></i> Harga Jual Per KG
                                </h6>
                                <p class="h5 mb-0 text-success">{{ number_format($fish->sell_price_per_kg) }} Coins</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="text-muted mb-2">
                                    <i class="bi bi-percent"></i> Probabilitas Ditangkap
                                </h6>
                                <p class="h5 mb-0">{{ $fish->catch_probability }}%</p>
                                <div class="progress mt-2" style="height: 10px;">
                                    <div class="progress-bar bg-info" role="progressbar" 
                                         style="width: {{ min($fish->catch_probability, 100) }}%">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="text-muted mb-2">
                                    <i class="bi bi-calculator"></i> Harga Jual Maksimum
                                </h6>
                                <p class="h5 mb-0 text-warning">
                                    {{ number_format($fish->base_weight_max * $fish->sell_price_per_kg) }} Coins
                                </p>
                                <small class="text-muted">Diberat Maksimum</small>
                            </div>
                        </div>
                    </div>

                    @if($fish->description)
                    <div class="col-md-12 mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="text-muted mb-2">
                                    <i class="bi bi-file-text"></i> Deskripsi
                                </h6>
                                <p class="mb-0">{{ $fish->description }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="col-md-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-muted mb-2">
                                            <i class="bi bi-calendar-plus"></i> Waktu Dibuat
                                        </h6>
                                        <p class="mb-0">{{ $fish->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-muted mb-2">
                                            <i class="bi bi-calendar-check"></i> Terakhir Diupdate
                                        </h6>
                                        <p class="mb-0">{{ $fish->updated_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('fishes.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    <div>
                        <a href="{{ route('fishes.edit', $fish->id) }}" class="btn btn-warning me-2">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <form action="{{ route('fishes.destroy', $fish->id) }}" method="POST" class="d-inline" 
                              onsubmit="return confirm('Are you sure you want to delete this fish?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-trash"></i> Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection