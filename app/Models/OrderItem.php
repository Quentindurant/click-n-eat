<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'item_id',
        'quantity',
        'unit_price',
        'subtotal',
        'special_instructions',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Get the order that owns the order item.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the item that the order item refers to.
     */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Calculate the subtotal for this order item.
     */
    public function calculateSubtotal()
    {
        $this->subtotal = $this->quantity * $this->unit_price;
        $this->save();
        
        // Update the order total
        $this->order->calculateTotal();
        
        return $this->subtotal;
    }
}
