@extends('layout.main')

@section('title', 'Liste des catégories')

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Liste des catégories</h3>
                    <div class="card-tools">
                        <a href="{{ route('categories.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Ajouter une catégorie
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
                                    <th>Restaurant</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            @if($category->restaurant)
                                                <a href="{{ route('restaurants.show', $category->restaurant->id) }}" 
                                                   class="text-decoration-none">
                                                    {{ $category->restaurant->name }}
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('categories.show', $category->id) }}" 
                                                   class="btn btn-sm btn-info" 
                                                   title="Voir">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('categories.edit', $category->id) }}" 
                                                   class="btn btn-sm btn-warning" 
                                                   title="Modifier">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('categories.destroy', $category->id) }}" 
                                                      method="POST" 
                                                      style="display: inline;">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="id" value="{{ $category->id }}">
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            title="Supprimer"
                                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
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