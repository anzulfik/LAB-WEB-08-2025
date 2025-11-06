<?php

namespace App\Http\Controllers;

use App\Models\Fish;
use Illuminate\Http\Request;

class FishController extends Controller
{
    public function index(Request $request)
    {
        $rarity = $request->input('rarity');
        $search = $request->input('search');

        $fishes = Fish::query()
            ->rarity($rarity)
            ->when($search, fn($q) => $q->where('name', 'like', "%$search%"))
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $rarities = ['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'];

        return view('fishes.index', compact('fishes','rarity','rarities','search'));
    }

    public function create()
    {
        $rarities = ['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'];
        return view('fishes.create', compact('rarities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required',
            'base_weight_min' => 'required|numeric|min:0',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|min:0.01|max:100',
        ]);

        Fish::create($request->all());
        return redirect()->route('fishes.index');
    }

    public function show(Fish $fish)
    {
        return view('fishes.show', compact('fish'));
    }

    public function edit(Fish $fish)
    {
        $rarities = ['Common','Uncommon','Rare','Epic','Legendary','Mythic','Secret'];
        return view('fishes.edit', compact('fish','rarities'));
    }

    public function update(Request $request, Fish $fish)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'rarity' => 'required',
            'base_weight_min' => 'required|numeric|min:0',
            'base_weight_max' => 'required|numeric|gt:base_weight_min',
            'sell_price_per_kg' => 'required|integer|min:0',
            'catch_probability' => 'required|numeric|min:0.01|max:100',
        ]);

        $fish->update($request->all());
        return redirect()->route('fishes.index');
    }

    public function destroy(Fish $fish)
    {
        $fish->delete();
        return redirect()->route('fishes.index');
    }

}


