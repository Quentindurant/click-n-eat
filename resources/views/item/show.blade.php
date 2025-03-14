@extends('layout.main')

@section('title', $item->name)

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $item->name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('items.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Retour à la liste
                        </a>
                        <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Modifier
                        </a>
                        <form action="{{ route('items.destroy', $item->id) }}" 
                              method="POST" 
                              style="display: inline;">
                            @csrf
                            @method('delete')
                            <button type="submit" 
                                    class="btn btn-danger" 
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet item ?')">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-info">
                                    <i class="bi bi-currency-euro"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Prix</span>
                                    <span class="info-box-number">{{ number_format($item->price / 100, 2) }}€</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning">
                                    <i class="bi bi-cash"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Coût</span>
                                    <span class="info-box-number">
                                        {{ $item->cost ? number_format($item->cost / 100, 2) . '€' : 'Non défini' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-success">
                                    <i class="bi bi-tag"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Catégorie</span>
                                    <span class="info-box-number">
                                        @if($item->category)
                                            <a href="{{ route('categories.show', $item->category->id) }}" 
                                               class="text-decoration-none">
                                                {{ $item->category->name }}
                                            </a>
                                        @else
                                            Non définie
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span class="info-box-icon {{ $item->is_active ? 'bg-success' : 'bg-danger' }}">
                                    <i class="bi bi-toggle2-{{ $item->is_active ? 'on' : 'off' }}"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Statut</span>
                                    <span class="info-box-number">
                                        {{ $item->is_active ? 'Actif' : 'Inactif' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection