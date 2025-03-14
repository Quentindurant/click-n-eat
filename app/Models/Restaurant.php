<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Reservation;
use App\Models\Order;

class Restaurant extends Model
{

    use HasFactory;

    protected $table = "restaurants";

    protected $fillable = [
        "name"
    ];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get the reservations for the restaurant.
     */
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Get the orders for the restaurant.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}