@extends('layout.main')

@section('title', 'Créer une réservation')

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Créer une réservation</h3>
                    <div class="card-tools">
                        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('reservations.store') }}" method="POST">
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
                            <label for="reservation_date" class="form-label">Date et heure</label>
                            <input type="datetime-local" name="reservation_date" id="reservation_date" class="form-control @error('reservation_date') is-invalid @enderror" required>
                            @error('reservation_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="number_of_guests" class="form-label">Nombre de personnes</label>
                            <input type="number" name="number_of_guests" id="number_of_guests" class="form-control @error('number_of_guests') is-invalid @enderror" min="1" value="2" required>
                            @error('number_of_guests')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="special_requests" class="form-label">Demandes spéciales</label>
                            <textarea name="special_requests" id="special_requests" class="form-control @error('special_requests') is-invalid @enderror" rows="3"></textarea>
                            @error('special_requests')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Enregistrer
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
    document.getElementById('reservation_date').min = minDateTime;
    document.getElementById('reservation_date').value = minDateTime;
</script>
@endsection
