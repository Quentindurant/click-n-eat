<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Order;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'reservation_date',
        'number_of_guests',
        'status',
        'special_requests',
    ];

    protected $casts = [
        'reservation_date' => 'datetime',
        'number_of_guests' => 'integer',
    ];

    /**
     * Get the user that owns the reservation.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the restaurant that the reservation is for.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Get the order associated with the reservation.
     */
    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
