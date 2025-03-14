<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index() {
        return view('categories.index', [
            'categories' => Category::with('restaurant')->get()
        ]);
    }

    public function create() {
        return view('categories.create', [
            'restaurants' => \App\Models\Restaurant::all()
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'restaurant_id' => 'required|exists:restaurants,id',
        ]);
        
        Category::create($validated);
        return redirect()->route('categories.index')->with('success', 'Catégorie créée avec succès');
    }

    public function show($id) {
        return view('categories.show', [
            'category' => Category::with(['items', 'restaurant'])->findOrFail($id)
        ]);
    }

    public function edit($id) {
        return view('categories.edit', [
            'category' => Category::findOrFail($id)
        ]);
    }

    public function update(Request $request, $id) {
        $category = Category::findOrFail($id);
        $category->update($request->all());
        return redirect()->route('categories.index');
    }

    public function destroy($id) {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index');
    }
}