<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Récupérer les statistiques pour le dashboard
        $restaurantsCount = Restaurant::count();
        $categoriesCount = Category::count();
        $itemsCount = Item::count();
        $user = Auth::user();

        return view('dashboard', compact('restaurantsCount', 'categoriesCount', 'itemsCount', 'user'));
    }
}
