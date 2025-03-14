@extends('layout.main')

@section('main')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Dashboard</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        Bienvenue {{ $user->name }} ! Vous êtes connecté.
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $restaurantsCount }}</h3>
                    <p>Restaurants</p>
                </div>
                <div class="icon">
                    <i class="bi bi-shop"></i>
                </div>
                <a href="{{ route('restaurants.index') }}" class="small-box-footer">
                    Gérer les restaurants <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $categoriesCount }}</h3>
                    <p>Catégories</p>
                </div>
                <div class="icon">
                    <i class="bi bi-tags"></i>
                </div>
                <a href="{{ route('categories.index') }}" class="small-box-footer">
                    Gérer les catégories <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $itemsCount }}</h3>
                    <p>Items</p>
                </div>
                <div class="icon">
                    <i class="bi bi-box"></i>
                </div>
                <a href="{{ route('items.index') }}" class="small-box-footer">
                    Gérer les items <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>Profil</h3>
                    <p>{{ $user->email }}</p>
                </div>
                <div class="icon">
                    <i class="bi bi-person"></i>
                </div>
                <a href="{{ route('profile.edit') }}" class="small-box-footer">
                    Modifier votre profil <i class="bi bi-arrow-right-circle"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
