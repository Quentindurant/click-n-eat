@extends('layout.main')

@section('title', 'Modifier une commande')

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Modifier la commande #{{ $order->id }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.update', $order->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="restaurant_id" class="form-label">Restaurant</label>
                            <select name="restaurant_id" id="restaurant_id" class="form-control @error('restaurant_id') is-invalid @enderror" required>
                                <option value="">Sélectionnez un restaurant</option>
                                @foreach($restaurants as $restaurant)
                                    <option value="{{ $restaurant->id }}" {{ $order->restaurant_id == $restaurant->id ? 'selected' : '' }}>
                                        {{ $restaurant->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('restaurant_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="reservation_id" class="form-label">Réservation (optionnel)</label>
                            <select name="reservation_id" id="reservation_id" class="form-control @error('reservation_id') is-invalid @enderror">
                                <option value="">Aucune réservation</option>
                                @if($reservations && $reservations->count() > 0)
                                    @foreach($reservations as $reservation)
                                        <option value="{{ $reservation->id }}" {{ $order->reservation_id == $reservation->id ? 'selected' : '' }}>
                                            #{{ $reservation->id }} - {{ $reservation->restaurant->name }} - 
                                            {{ date('d/m/Y H:i', strtotime($reservation->reservation_date)) }} - 
                                            {{ $reservation->number_of_guests }} personnes
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('reservation_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">Statut</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="confirmed" {{ $order->status == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                                <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>En préparation</option>
                                <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Prête</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Terminée</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="pickup_time" class="form-label">Heure de retrait</label>
                            <input type="datetime-local" name="pickup_time" id="pickup_time" 
                                   value="{{ date('Y-m-d\TH:i', strtotime($order->pickup_time)) }}" 
                                   class="form-control @error('pickup_time') is-invalid @enderror" required>
                            @error('pickup_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ $order->notes }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
