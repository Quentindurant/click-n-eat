<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Item;
use App\Models\Restaurant;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['restaurant', 'user', 'reservation'])->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $restaurants = Restaurant::all();
        $reservations = Reservation::where('user_id', Auth::id())
            ->where('status', 'confirmed')
            ->whereDoesntHave('order')
            ->get();
            
        return view('orders.create', compact('restaurants', 'reservations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'reservation_id' => 'nullable|exists:reservations,id',
            'pickup_time' => 'required|date|after:now',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';
        $validated['total_amount'] = 0; // Will be updated when items are added

        $order = Order::create($validated);

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order created successfully. Add items to your order.');
    }

    public function show($id)
    {
        return view('orders.show', [
            'order' => Order::with(['restaurant', 'user', 'reservation', 'items.item'])->findOrFail($id),
            'restaurantItems' => Item::where('category_id', function($query) use ($id) {
                $query->select('id')
                    ->from('categories')
                    ->where('restaurant_id', Order::findOrFail($id)->restaurant_id);
            })->get()
        ]);
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $restaurants = Restaurant::all();
        $reservations = Reservation::where('user_id', Auth::id())
            ->where(function($query) use ($order) {
                $query->where('status', 'confirmed')
                    ->whereDoesntHave('order')
                    ->orWhere('id', $order->reservation_id);
            })
            ->get();
            
        return view('orders.edit', compact('order', 'restaurants', 'reservations'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'reservation_id' => 'nullable|exists:reservations,id',
            'status' => 'required|in:pending,confirmed,preparing,ready,completed,cancelled',
            'pickup_time' => 'required|date',
            'notes' => 'nullable|string',
        ]);
        
        $order->update($validated);
        
        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order updated successfully.');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();
        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    // Methods for managing order items
    public function addItem(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);
        
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'special_instructions' => 'nullable|string',
        ]);
        
        $item = Item::findOrFail($validated['item_id']);
        
        $orderItem = new OrderItem([
            'order_id' => $order->id,
            'item_id' => $item->id,
            'quantity' => $validated['quantity'],
            'unit_price' => $item->price,
            'subtotal' => $item->price * $validated['quantity'],
            'special_instructions' => $validated['special_instructions'] ?? null,
        ]);
        
        $orderItem->save();
        
        // Update order total
        $order->calculateTotal();
        
        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Item added to order successfully.');
    }
    
    public function updateItem(Request $request, $orderId, $itemId)
    {
        $orderItem = OrderItem::where('order_id', $orderId)
            ->where('id', $itemId)
            ->firstOrFail();
        
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'special_instructions' => 'nullable|string',
        ]);
        
        $orderItem->quantity = $validated['quantity'];
        $orderItem->special_instructions = $validated['special_instructions'] ?? null;
        $orderItem->subtotal = $orderItem->unit_price * $validated['quantity'];
        $orderItem->save();
        
        // Update order total
        $orderItem->order->calculateTotal();
        
        return redirect()->route('orders.show', $orderId)
            ->with('success', 'Order item updated successfully.');
    }
    
    public function removeItem($orderId, $itemId)
    {
        $orderItem = OrderItem::where('order_id', $orderId)
            ->where('id', $itemId)
            ->firstOrFail();
        
        $order = $orderItem->order;
        
        $orderItem->delete();
        
        // Update order total
        $order->calculateTotal();
        
        return redirect()->route('orders.show', $orderId)
            ->with('success', 'Item removed from order successfully.');
    }
}
