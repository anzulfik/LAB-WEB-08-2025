<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use App\Http\Requests\StoreFishRequest;
use Illuminate\Http\Request;

class FishController extends Controller
{
    private $rarities = ['Common', 'Uncommon', 'Rare', 'Epic', 'Legendary', 'Mythic', 'Secret'];

    public function tampilkanSemua(Request $request)
    {
        $fishes = Fish::latest()
            ->filter($request->only(['search', 'rarity']))
            ->paginate(10)
            ->withQueryString();

        return view('ikan.index', [
            'fishes' => $fishes,
            'rarities' => $this->rarities,
            'filters' => $request->only(['search', 'rarity'])
        ]);
    }

    public function buat()
    {
        return view('ikan.create', ['rarities' => $this->rarities]);
    }

    public function simpan(StoreFishRequest $request)
    {
        Fish::create($request->validated());

        return redirect()->route('ikan.index')
            ->with('success', 'Ikan baru berhasil ditambahkan!');
    }

    public function tampilkan(Fish $fish)
    {
        return view('ikan.show', ['fish' => $fish]);
    }

    public function ubah(Fish $fish)
    {
        return view('ikan.edit', [
            'fish' => $fish, 
            'rarities' => $this->rarities
        ]);
    }

    public function perbarui(StoreFishRequest $request, Fish $fish)
    {
        $fish->update($request->validated());

        return redirect()->route('ikan.index')
            ->with('success', 'Data ikan berhasil diperbarui.');
    }

    public function hapus(Fish $fish)
    {
        $fish->delete();

        return redirect()->route('ikan.index')
            ->with('success', 'Data ikan berhasil dihapus.');
    }
}