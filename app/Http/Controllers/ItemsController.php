<?php

namespace App\Http\Controllers;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->get();
        return view('item.index', ['items' => $items]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('item.create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id'
        ]);

        Item::create($validated);
        return redirect()->route('items.index')->with('success', 'Item créé avec succès');
    }

    public function show($id)
    {
        $item = Item::with('category')->findOrFail($id);
        return view('item.show', ['item' => $item]);
    }

    public function edit($id)
    {
        $item = Item::findOrFail($id);
        $categories = Category::all();
        return view('item.edit', [
            'item' => $item,
            'categories' => $categories
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id'
        ]);

        $item = Item::findOrFail($id);
        $item->update($validated);

        return redirect()->route('items.index')->with('success', 'Item mis à jour avec succès');
    }

    public function destroy($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        return redirect()->route('items.index')->with('success', 'Item supprimé avec succès');
    }
}
