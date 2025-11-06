<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;

class FishController extends Controller
{
    /**
     * Tampilkan daftar semua ikan dengan filter dan paginasi.
     */
    public function index(Request $request)
    {
        // Mulai query builder
        $query = Fish::query();

        // Terapkan filter berdasarkan rarity
        if ($request->filled('rarity')) {
            $query->byRarity($request->rarity);
        }

        // Terapkan filter pencarian nama
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Ambil data, urutkan, dan bagi per 10 item per halaman
        $fishes = $query->orderBy('created_at', 'desc')->paginate(10);

        // Pertahankan parameter filter (cth: ?rarity=Common) pada link paginasi
        $fishes->appends($request->all());

        // Kirim data ke view
        return view('fishes.index', compact('fishes'));
    }

    /**
     * Tampilkan form untuk menambah ikan baru.
     */
    public function create()
    {
        return view('fishes.create');
    }

    /**
     * Simpan ikan baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $validated = $request->validate(
            Fish::validationRules(),
            Fish::validationMessages()
        );

        try {
            // Buat data ikan baru
            Fish::create($validated);

            // Alihkan ke index jika sukses
            return redirect()
                ->route('fishes.index')
                ->with('success', 'Fish "' . $validated['name'] . '" has been added successfully!');
        } catch (\Exception $e) {
            // Kembali ke form jika gagal
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to add fish. Please try again.');
        }
    }

    /**
     * Tampilkan detail satu ikan.
     *
     * @param  \App\Models\Fish  $fish
     * Laravel otomatis mencari Fish berdasarkan ID di URL (Route Model Binding)
     */
    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }

    /**
     * Tampilkan form untuk mengedit ikan.
     *
     * @param  \App\Models\Fish  $fish
     * $fish otomatis didapat dari ID di URL
     */
    public function edit(Fish $fish)
    {
        return view('fishes.edit', compact('fish'));
    }

    /**
     * Perbarui data ikan yang ada di database.
     */
    public function update(Request $request, Fish $fish)
    {
        // Validasi input dari form
        $validated = $request->validate(
            Fish::validationRules($fish->id),
            Fish::validationMessages()
        );

        try {
            // Update data ikan
            $fish->update($validated);

            // Alihkan ke halaman detail jika sukses
            return redirect()
                ->route('fishes.show', $fish->id)
                ->with('success', 'Fish "' . $fish->name . '" has been updated successfully!');
        } catch (\Exception $e) {
            // Kembali ke form jika gagal
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update fish. Please try again.');
        }
    }

    /**
     * Hapus data ikan dari database.
     */
    public function destroy(Fish $fish)
    {
        try {
            // Simpan nama untuk pesan sukses
            $fishName = $fish->name;
            // Hapus data
            $fish->delete();

            // Alihkan ke index jika sukses
            return redirect()
                ->route('fishes.index')
                ->with('success', 'Fish "' . $fishName . '" has been deleted successfully!');
        } catch (\Exception $e) {
            // Tangkap jika terjadi error
            return redirect()
                ->back()
                ->with('error', 'Failed to delete fish. Please try again.');
        }
    }
}