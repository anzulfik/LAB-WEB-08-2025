<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FishController extends Controller
{
    public function index(Request $request)
    {
        $rarities = ['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'];

        // 🔹 Fitur Search + Filter + Sorting
        $fishes = Fish::query()
            ->search($request->search)
            ->rarity($request->rarity)
            ->when($request->sort, function ($query, $sort) {
                // Jika user memilih opsi sorting
                switch ($sort) {
                    case 'name':
                        $query->orderBy('name', 'asc'); // urut A-Z
                        break;
                    case 'price':
                        $query->orderBy('sell_price_per_kg', 'desc'); // harga tertinggi
                        break;
                    case 'probability':
                        $query->orderBy('catch_probability', 'desc'); // peluang tertinggi
                        break;
                    default:
                        $query->latest(); // default urut berdasarkan waktu tambah
                }
            }, function ($query) {
                // Jika tidak ada parameter sort, tetap urut terbaru
                $query->latest();
            })
            ->paginate(10)
            ->withQueryString();

        // 🔸 Kirim semua variabel ke view
        return view('fishes.index', compact('fishes', 'rarities'));
    }

    public function create()
    {
        $rarities = ['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'];
        return view('fishes.create', compact('rarities'));
    }

    public function store(Request $request)
    {
        // 🔹 Validasi input user
        $data = $request->validate([
            'name' => 'required|max:100',
            'rarity' => ['required', Rule::in(['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'])],
            'base_weight_min' => 'required|numeric|min:0',
            'base_weight_max' => 'required|numeric|min:0',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|min:0.01|max:100',
            'description' => 'nullable|string',
        ]);

        // 🔹 Validasi tambahan: berat maksimum harus lebih besar dari minimum
        if ($data['base_weight_max'] <= $data['base_weight_min']) {
            return back()->withInput()
                ->withErrors(['base_weight_max' => 'Berat maksimum harus lebih besar dari berat minimum.']);
        }

        // 🔹 Simpan ke database
        Fish::create($data);

        // 🔹 Redirect ke halaman daftar ikan
        return redirect()->route('fishes.index')->with('success', 'Data ikan berhasil ditambahkan!');
    }

    public function show(Fish $fish)
    {
        // 🔹 Menampilkan detail satu ikan
        return view('fishes.show', compact('fish'));
    }

    public function edit(Fish $fish)
    {
        $rarities = ['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'];
        return view('fishes.edit', compact('fish', 'rarities'));
    }

    public function update(Request $request, Fish $fish)
    {
        // 🔹 Validasi data update
        $data = $request->validate([
            'name' => 'required|max:100',
            'rarity' => ['required', Rule::in(['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'])],
            'base_weight_min' => 'required|numeric|min:0',
            'base_weight_max' => 'required|numeric|min:0',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|min:0.01|max:100',
            'description' => 'nullable|string',
        ]);

        // 🔹 Cek berat maksimum > minimum
        if ($data['base_weight_max'] <= $data['base_weight_min']) {
            return back()->withInput()
                ->withErrors(['base_weight_max' => 'Berat maksimum harus lebih besar dari berat minimum.']);
        }

        // 🔹 Update data
        $fish->update($data);

        return redirect()->route('fishes.index')->with('success', 'Data ikan berhasil diperbarui!');
    }

    public function destroy(Fish $fish)
    {
        // 🔹 Hapus data ikan dari database
        $fish->delete();

        // 🔹 Redirect dengan pesan sukses
        return redirect()->route('fishes.index')->with('success', 'Data ikan berhasil dihapus!');
    }
}
