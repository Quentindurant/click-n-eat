@extends('layout.main')

@section('title', 'Liste des commandes')

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Liste des commandes</h3>
                    <div class="card-tools">
                        <a href="{{ route('orders.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Nouvelle commande
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(!$orders || $orders->isEmpty())
                        <div class="alert alert-info">
                            Aucune commande trouvée.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Restaurant</th>
                                        <th>Client</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th>Heure de retrait</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>
                                                @if($order->restaurant)
                                                    <a href="{{ route('restaurants.show', $order->restaurant->id) }}" 
                                                       class="text-decoration-none">
                                                        {{ $order->restaurant->name }}
                                                    </a>
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $order->user->name }}</td>
                                            <td>{{ number_format($order->total_amount, 2) }} €</td>
                                            <td>
                                                <span class="badge 
                                                    @if($order->status == 'pending') bg-warning
                                                    @elseif($order->status == 'confirmed') bg-info
                                                    @elseif($order->status == 'preparing') bg-primary
                                                    @elseif($order->status == 'ready') bg-success
                                                    @elseif($order->status == 'completed') bg-secondary
                                                    @elseif($order->status == 'cancelled') bg-danger
                                                    @endif">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td>{{ date('d/m/Y H:i', strtotime($order->pickup_time)) }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('orders.show', $order->id) }}" 
                                                       class="btn btn-sm btn-info" 
                                                       title="Voir">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('orders.edit', $order->id) }}" 
                                                       class="btn btn-sm btn-warning" 
                                                       title="Modifier">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('orders.destroy', $order->id) }}" 
                                                          method="POST" 
                                                          style="display: inline;">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" 
                                                                class="btn btn-sm btn-danger" 
                                                                title="Supprimer"
                                                                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')">
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
                            {{ $orders->links() }}
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
        console.log("Liste des commandes chargée !");
    </script>
@endsection
