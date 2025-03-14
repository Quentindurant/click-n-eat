<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::with(['restaurant', 'user'])->latest()->paginate(10);
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reservations.create', [
            'restaurants' => Restaurant::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'reservation_date' => 'required|date|after:now',
            'number_of_guests' => 'required|integer|min:1',
            'special_requests' => 'nullable|string',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = 'pending';

        $reservation = Reservation::create($validated);

        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Reservation created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('reservations.show', [
            'reservation' => Reservation::with(['restaurant', 'user', 'order'])->findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('reservations.edit', [
            'reservation' => Reservation::findOrFail($id),
            'restaurants' => Restaurant::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'reservation_date' => 'required|date',
            'number_of_guests' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'special_requests' => 'nullable|string',
        ]);

        $reservation->update($validated);

        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Reservation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return redirect()->route('reservations.index')
            ->with('success', 'Reservation deleted successfully.');
    }
}
