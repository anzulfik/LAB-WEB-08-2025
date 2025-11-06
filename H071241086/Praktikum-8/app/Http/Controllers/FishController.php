<?php
namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // ← tambahkan ini untuk menjalankan perintah SQL

class FishController extends Controller
{
    public function index(Request $request)
    {
        $query = Fish::query();

    if ($request->filled('search')) {
        $s = $request->get('search');
        $query->where('name', 'LIKE', "%{$s}%");
    }

    if ($request->filled('rarity')) {
        $query->where('rarity', $request->rarity);
    }

    if ($request->filled('sort_by')) {
        $dir = $request->get('dir', 'desc');
        $query->orderBy($request->sort_by, $dir);
        
    } else {
        $query->orderBy('id', 'asc');
    }

    $fishes = $query->paginate(10)->withQueryString();
    $rarities = ['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'];

    return view('fishes.index', compact('fishes', 'rarities'));
}

    public function create()
    {
        $rarities = ['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'];
        return view('fishes.create', compact('rarities'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric|min:0.01',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|min:0.01|max:100',
            'description' => 'nullable|string',
        ];

        $messages = [
            'base_weight_min.min' => 'Berat minimum harus lebih dari 0.',
            'base_weight_max.gt' => 'Berat maksimum harus lebih besar dari berat minimum.',
            'catch_probability.min' => 'Peluang tertangkap minimal 0,01%.',
            'catch_probability.max' => 'Peluang tertangkap tidak boleh lebih dari 100%.',
        ];

        $validated = $request->validate($rules, $messages);
        Fish::create($validated);

        return redirect()->route('fishes.index')->with('success', 'Ikan berhasil ditambahkan!');
    }

    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }

    public function edit(Fish $fish)
    {
        $rarities = ['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'];
        return view('fishes.edit', compact('fish', 'rarities'));
    }

    public function update(Request $request, Fish $fish)
    {
        $rules = [
            'name' => 'required|string|max:100',
            'rarity' => 'required|in:Common,Uncommon,Rare,Epic,Legendary,Mythic,Secret',
            'base_weight_min' => 'required|numeric|min:0.01',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|min:0.01|max:100',
            'description' => 'nullable|string',
        ];

        $messages = [
            'base_weight_min.min' => 'Berat minimum harus lebih dari 0.',
            'base_weight_max.gt' => 'Berat maksimum harus lebih besar dari berat minimum.',
            'catch_probability.min' => 'Peluang tertangkap minimal 0,01%.',
            'catch_probability.max' => 'Peluang tertangkap tidak boleh lebih dari 100%.',
        ];

        $validated = $request->validate($rules, $messages);
        $fish->update($validated);

        return redirect()->route('fishes.index')->with('success', 'Data ikan berhasil diperbarui!');
    }

    public function destroy(Fish $fish)
    {
        $fish->delete();
        return redirect()->route('fishes.index')->with('success', 'Ikan berhasil dihapus!');
    }

}
