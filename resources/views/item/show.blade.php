@extends('layout.main')

@section('main')
    <h1>Item : {{ $item->name }}</h1>

    <a href="{{ route('items.index') }}">Retour à la liste</a>

    <ul>
        <li>ID : {{ $item->id }}</li>
        <li>Nom : {{ $item->name }}</li>
        <li>Prix : {{ number_format($item->price / 100, 2) }}€</li>
        <li>Coût : {{ $item->cost ? number_format($item->cost / 100, 2) . '€' : 'Non défini' }}</li>
        <li>Statut : {{ $item->is_active ? 'Actif' : 'Inactif' }}</li>
        <li>Créé le : {{ $item->created_at }}</li>
        <li>Mis à jour le : {{ $item->updated_at }}</li>
    </ul>
    
    <h2>Catégorie</h2>
    <p><a href="{{ route('categories.show', $item->category_id) }}">{{ $item->category->name }}</a></p>
@endsection