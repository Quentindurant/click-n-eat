@extends('layout.main')

@section('title', 'Créer une commande')

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Créer une commande</h3>
                    <div class="card-tools">
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('orders.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="restaurant_id" class="form-label">Restaurant</label>
                            <select name="restaurant_id" id="restaurant_id" class="form-control @error('restaurant_id') is-invalid @enderror" required>
                                <option value="">Sélectionnez un restaurant</option>
                                @foreach($restaurants as $restaurant)
                                    <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
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
                                        <option value="{{ $reservation->id }}">
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
                            <small class="form-text text-muted">
                                Si vous sélectionnez une réservation, le restaurant sera automatiquement celui de la réservation.
                            </small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="pickup_time" class="form-label">Heure de retrait</label>
                            <input type="datetime-local" name="pickup_time" id="pickup_time" class="form-control @error('pickup_time') is-invalid @enderror" required>
                            @error('pickup_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3"></textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Créer la commande
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Définir la date minimale à aujourd'hui
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    const hours = String(today.getHours()).padStart(2, '0');
    const minutes = String(today.getMinutes()).padStart(2, '0');
    
    const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
    document.getElementById('pickup_time').min = minDateTime;
    document.getElementById('pickup_time').value = minDateTime;
    
    // Mettre à jour le restaurant en fonction de la réservation
    document.getElementById('reservation_id').addEventListener('change', function() {
        const reservationSelect = this;
        const restaurantSelect = document.getElementById('restaurant_id');
        
        if (reservationSelect.value) {
            // Trouver l'option qui contient le nom du restaurant
            const selectedOption = reservationSelect.options[reservationSelect.selectedIndex];
            const text = selectedOption.text;
            const restaurantName = text.split(' - ')[1];
            
            // Parcourir les options du restaurant pour trouver celle qui correspond
            for (let i = 0; i < restaurantSelect.options.length; i++) {
                if (restaurantSelect.options[i].text === restaurantName) {
                    restaurantSelect.value = restaurantSelect.options[i].value;
                    restaurantSelect.disabled = true;
                    break;
                }
            }
        } else {
            restaurantSelect.disabled = false;
        }
    });
</script>
@endsection
