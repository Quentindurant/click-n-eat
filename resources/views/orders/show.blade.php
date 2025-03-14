@extends('layout.main')

@section('title', 'Détails de la commande #' . $order->id)

@section('main')
<div class="mt-5">
    <div class="row mb-4 mt-4">
        <div class="col-md-6">
            <h1>Détails de la commande #{{ $order->id }}</h1>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Retour à la liste
            </a>
            <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary">
                <i class="bi bi-pencil"></i> Modifier
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">Informations générales</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table">
                                <tr>
                                    <th>Restaurant</th>
                                    <td>
                                        <a href="{{ route('restaurants.show', $order->restaurant_id) }}">
                                            {{ $order->restaurant->name }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Client</th>
                                    <td>{{ $order->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Statut</th>
                                    <td>
                                        <span class="badge 
                                            @if($order->status == 'pending') bg-warning
                                            @elseif($order->status == 'confirmed') bg-success
                                            @elseif($order->status == 'completed') bg-info
                                            @elseif($order->status == 'cancelled') bg-danger
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Heure de retrait</th>
                                    <td>{{ date('d/m/Y H:i', strtotime($order->pickup_time)) }}</td>
                                </tr>
                                <tr>
                                    <th>Montant total</th>
                                    <td>{{ number_format($order->total_amount, 2) }} €</td>
                                </tr>
                                <tr>
                                    <th>Notes</th>
                                    <td>{{ $order->notes ?: 'Aucune note' }}</td>
                                </tr>
                                <tr>
                                    <th>Créée le</th>
                                    <td>{{ date('d/m/Y H:i', strtotime($order->created_at)) }}</td>
                                </tr>
                                <tr>
                                    <th>Mise à jour le</th>
                                    <td>{{ date('d/m/Y H:i', strtotime($order->updated_at)) }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header bg-info text-white">
                                    <h5 class="card-title mb-0">Réservation associée</h5>
                                </div>
                                <div class="card-body">
                                    @if(isset($order->reservation) && $order->reservation)
                                        <div class="alert alert-info">
                                            <p>Cette commande est liée à la réservation #{{ $order->reservation->id }}</p>
                                            <a href="{{ route('reservations.show', $order->reservation->id) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i> Voir la réservation
                                            </a>
                                        </div>
                                        <table class="table">
                                            <tr>
                                                <th>Statut de la réservation</th>
                                                <td>
                                                    <span class="badge 
                                                        @if($order->reservation->status == 'pending') bg-warning
                                                        @elseif($order->reservation->status == 'confirmed') bg-success
                                                        @elseif($order->reservation->status == 'completed') bg-info
                                                        @elseif($order->reservation->status == 'cancelled') bg-danger
                                                        @endif">
                                                        {{ ucfirst($order->reservation->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Date de réservation</th>
                                                <td>{{ date('d/m/Y H:i', strtotime($order->reservation->reservation_date)) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Nombre de personnes</th>
                                                <td>{{ $order->reservation->number_of_guests }}</td>
                                            </tr>
                                        </table>
                                    @else
                                        <div class="alert alert-warning">
                                            Aucune réservation n'est associée à cette commande.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">Articles de la commande</h5>
                                    <button type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#addItemModal">
                                        <i class="bi bi-plus-circle"></i> Ajouter un article
                                    </button>
                                </div>
                                <div class="card-body">
                                    @if(!$order->items || $order->items->isEmpty())
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle me-2"></i> Aucun article dans cette commande.
                                        </div>
                                    @else
                                        <div class="table-responsive">
                                            <table class="table table-hover table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Produit</th>
                                                        <th>Prix unitaire</th>
                                                        <th>Quantité</th>
                                                        <th>Sous-total</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($order->items as $item)
                                                        <tr>
                                                            <td>{{ $item->item->name }}</td>
                                                            <td>{{ number_format($item->unit_price, 2) }} €</td>
                                                            <td>{{ $item->quantity }}</td>
                                                            <td>{{ number_format($item->unit_price * $item->quantity, 2) }} €</td>
                                                            <td>
                                                                <div class="btn-group">
                                                                    <button type="button" class="btn btn-sm btn-primary edit-item-btn" 
                                                                        data-bs-toggle="modal" 
                                                                        data-bs-target="#editItemModal"
                                                                        data-item-id="{{ $item->id }}">
                                                                        <i class="bi bi-pencil"></i>
                                                                    </button>
                                                                    <form action="{{ route('orders.items.remove', [$order->id, $item->id]) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?')">
                                                                            <i class="bi bi-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="3" class="text-end">Total :</th>
                                                        <th>{{ number_format($order->total_amount, 2) }} €</th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')">
                            <i class="bi bi-trash"></i> Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajout d'article -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('orders.items.add', $order->id) }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addItemModalLabel">Ajouter un article</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="item_id" class="form-label">Produit</label>
                        <select name="item_id" id="item_id" class="form-control" required>
                            <option value="">Sélectionnez un produit</option>
                            @foreach($restaurantItems as $item)
                                <option value="{{ $item->id }}" data-price="{{ $item->price }}">
                                    {{ $item->name }} - {{ number_format($item->price, 2) }} €
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantité</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="special_instructions" class="form-label">Instructions spéciales</label>
                        <textarea name="special_instructions" id="special_instructions" class="form-control" rows="3" placeholder="Instructions spéciales pour la préparation..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Modification d'article -->
<div class="modal fade" id="editItemModal" tabindex="-1" aria-labelledby="editItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editItemModalLabel">Modifier un article</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulaires individuels pour chaque article -->
                @foreach($order->items as $orderItem)
                <form id="editItemForm{{ $orderItem->id }}" action="{{ route('orders.items.update', ['order' => $order->id, 'item' => $orderItem->id]) }}" method="POST" class="edit-item-form" style="display: none;">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Produit</label>
                        <input type="text" class="form-control" value="{{ $orderItem->item->name }} - {{ number_format($orderItem->unit_price, 2) }} €" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="quantity{{ $orderItem->id }}" class="form-label">Quantité</label>
                        <input type="number" name="quantity" id="quantity{{ $orderItem->id }}" class="form-control" min="1" value="{{ $orderItem->quantity }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="special_instructions{{ $orderItem->id }}" class="form-label">Instructions spéciales</label>
                        <textarea name="special_instructions" id="special_instructions{{ $orderItem->id }}" class="form-control" rows="3">{{ $orderItem->special_instructions }}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Enregistrer
                        </button>
                    </div>
                </form>
                @endforeach
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    // Gestionnaire pour le modal de modification d'article
    document.querySelectorAll('.edit-item-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const itemId = this.getAttribute('data-item-id');
            
            // Cacher tous les formulaires
            document.querySelectorAll('.edit-item-form').forEach(form => {
                form.style.display = 'none';
            });
            
            // Afficher le formulaire correspondant à l'article
            const form = document.getElementById('editItemForm' + itemId);
            if (form) {
                form.style.display = 'block';
            }
        });
    });
</script>
@endsection
