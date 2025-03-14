<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Reservation;
use App\Models\OrderItem;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'restaurant_id',
        'reservation_id',
        'status',
        'total_amount',
        'pickup_time',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'pickup_time' => 'datetime',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the restaurant that the order is for.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Get the reservation associated with the order.
     */
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * Get the items for the order.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Calculate the total amount of the order.
     */
    public function calculateTotal()
    {
        $total = $this->items->sum('subtotal');
        $this->total_amount = $total;
        $this->save();
        
        return $total;
    }
}
