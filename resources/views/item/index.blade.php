@extends('layout.main')

@section('title', 'Liste des items')

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Liste des items</h3>
                    <div class="card-tools">
                        <a href="{{ route('items.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Ajouter un item
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Prix</th>
                                    <th>Coût</th>
                                    <th>Catégorie</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ number_format($item->price / 100, 2) }}€</td>
                                        <td>{{ $item->cost ? number_format($item->cost / 100, 2) . '€' : '-' }}</td>
                                        <td>
                                            @if($item->category)
                                                <a href="{{ route('categories.show', $item->category->id) }}" 
                                                   class="text-decoration-none">
                                                    {{ $item->category->name }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->is_active)
                                                <span class="badge bg-success">Actif</span>
                                            @else
                                                <span class="badge bg-danger">Inactif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('items.show', $item->id) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="Voir">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('items.edit', $item->id) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Modifier">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('items.destroy', $item->id) }}" 
                                                      method="POST" 
                                                      style="display: inline;">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            title="Supprimer"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet item ?')">
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
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        console.log("scripts !");
    </script>
@endsection