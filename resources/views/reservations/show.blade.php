@extends('layout.main')

@section('title', 'Détails de la réservation')

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Réservation #{{ $reservation->id }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('reservations.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Retour à la liste
                        </a>
                        <a href="{{ route('reservations.edit', $reservation->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Informations générales</h4>
                            <table class="table">
                                <tr>
                                    <th>Restaurant</th>
                                    <td>
                                        <a href="{{ route('restaurants.show', $reservation->restaurant->id) }}">
                                            {{ $reservation->restaurant->name }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Client</th>
                                    <td>{{ $reservation->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Date et heure</th>
                                    <td>{{ date('d/m/Y H:i', strtotime($reservation->reservation_date)) }}</td>
                                </tr>
                                <tr>
                                    <th>Nombre de personnes</th>
                                    <td>{{ $reservation->number_of_guests }}</td>
                                </tr>
                                <tr>
                                    <th>Statut</th>
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
                                </tr>
                                <tr>
                                    <th>Demandes spéciales</th>
                                    <td>{{ $reservation->special_requests ?: 'Aucune' }}</td>
                                </tr>
                                <tr>
                                    <th>Créée le</th>
                                    <td>{{ date('d/m/Y H:i', strtotime($reservation->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <th>Mise à jour le</th>
                                    <td>{{ date('d/m/Y H:i', strtotime($reservation->updated_at)) }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h4>Commande associée</h4>
                            @if($reservation->order)
                                <div class="alert alert-info">
                                    <p>Cette réservation est liée à la commande #{{ $reservation->order->id }}</p>
                                    <a href="{{ route('orders.show', $reservation->order->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> Voir la commande
                                    </a>
                                </div>
                                <table class="table">
                                    <tr>
                                        <th>Statut de la commande</th>
                                        <td>
                                            <span class="badge 
                                                @if($reservation->order->status == 'pending') bg-warning
                                                @elseif($reservation->order->status == 'confirmed') bg-info
                                                @elseif($reservation->order->status == 'preparing') bg-primary
                                                @elseif($reservation->order->status == 'ready') bg-success
                                                @elseif($reservation->order->status == 'completed') bg-secondary
                                                @elseif($reservation->order->status == 'cancelled') bg-danger
                                                @endif">
                                                {{ ucfirst($reservation->order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Montant total</th>
                                        <td>{{ number_format($reservation->order->total_amount, 2) }} €</td>
                                    </tr>
                                    <tr>
                                        <th>Heure de retrait</th>
                                        <td>{{ date('d/m/Y H:i', strtotime($reservation->order->pickup_time)) }}</td>
                                    </tr>
                                </table>
                            @else
                                <div class="alert alert-warning">
                                    <p>Aucune commande n'est associée à cette réservation.</p>
                                    <a href="{{ route('orders.create') }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-plus-circle"></i> Créer une commande
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
