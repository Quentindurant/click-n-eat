@extends('layout.main')

@section('title', 'Liste des restaurants')

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Liste des restaurants</h3>
                    <div class="card-tools">
                        <a href="{{ route('restaurants.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Ajouter un restaurant
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
                                    <th>Nombre de catégories</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($restaurants as $restaurant)
                                    <tr>
                                        <td>{{ $restaurant->id }}</td>
                                        <td>{{ $restaurant->name }}</td>
                                        <td>
                                            <span class="badge bg-primary">{{ $restaurant->categories->count() }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('restaurants.show', $restaurant->id) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="Voir">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('restaurants.edit', $restaurant->id) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Modifier">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('restaurants.destroy', $restaurant->id) }}" 
                                                      method="POST" 
                                                      style="display: inline;">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="id" value="{{ $restaurant->id }}">
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            title="Supprimer"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce restaurant ?')">
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