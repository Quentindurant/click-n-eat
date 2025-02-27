@extends('layout.main')

@section('main')
    <h1>Restaurant : {{ $restaurant->name }}</h1>

    <a href="{{ route('restaurants.index') }}">Retour à la liste</a>
    <a href="{{ route('restaurants.create') }}">Créer un restaurant</a>

    <ul>
        <li>ID : {{ $restaurant->id }}</li>
        <li>Nom : {{ $restaurant->name }}</li>
        <li>Créé le : {{ $restaurant->created_at }}</li>
        <li>Mis à jour le : {{ $restaurant->updated_at }}</li>
    </ul>

    <h2>Catégories et leurs items</h2>

    @foreach($restaurant->categories as $category)
        <h3>{{ $category->name }}</h3>
        @if($category->items->count() > 0)
            <ul>
                @foreach($category->items as $item)
                    <li>
                        <a href="{{ route('items.show', $item->id) }}" title="Voir l'item">{{ $item->name }}</a>
                        - {{ number_format($item->price / 100, 2) }}€
                        @if(!$item->is_active)
                            (Inactif)
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p>Aucun item dans cette catégorie</p>
        @endif
    @endforeach
@endsection