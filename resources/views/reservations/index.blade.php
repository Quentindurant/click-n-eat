@extends('layout.main')

@section('title', 'Liste des réservations')

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Liste des réservations</h3>
                    <div class="card-tools">
                        <a href="{{ route('reservations.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Nouvelle réservation
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(!$reservations || $reservations->isEmpty())
                        <div class="alert alert-info">
                            Aucune réservation trouvée.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Restaurant</th>
                                        <th>Client</th>
                                        <th>Date</th>
                                        <th>Personnes</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reservations as $reservation)
                                        <tr>
                                            <td>{{ $reservation->id }}</td>
                                            <td>
                                                @if($reservation->restaurant)
                                                    <a href="{{ route('restaurants.show', $reservation->restaurant->id) }}" 
                                                       class="text-decoration-none">
                                                        {{ $reservation->restaurant->name }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $reservation->user->name }}</td>
                                            <td>{{ date('d/m/Y H:i', strtotime($reservation->reservation_date)) }}</td>
                                            <td>{{ $reservation->number_of_guests }}</td>
                                            <td>
                                                <span class="badge 
                                                    @if($reservation->status == 'pending') bg-warning
                                                    @elseif($reservation->status == 'confirmed') bg-success
                                                    @elseif($reservation->status == 'cancelled') bg-danger
                                                    @elseif($reservation->status == 'completed') bg-secondary
                                                    @endif">
                                                    {{ ucfirst($reservation->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('reservations.show', $reservation->id) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Voir">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('reservations.edit', $reservation->id) }}" 
                                                       class="btn btn-sm btn-warning" 
                                                       title="Modifier">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('reservations.destroy', $reservation->id) }}" 
                                                          method="POST" 
                                                          style="display: inline;">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-danger" 
                                                                title="Supprimer"
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            {{ $reservations->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        console.log("Liste des réservations chargée !");
    </script>
@endsection
