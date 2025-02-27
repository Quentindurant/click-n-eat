@extends('layout.main')

@section('main')
    <h1>Creation ITEM</h1>

    <a href="{{ route('items.index') }}">Retour à la liste</a>

    <form action="{{ route('items.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Nom : </label>
            <input type="text" id="name" name="name" placeholder="Nom" required>
        </div>
        <div>
            <label for="price">Prix : </label>
            <input type="number" id="price" name="price" placeholder="Prix" required>
        </div>
        <div>
            <label for="category_id">Catégorie : </label>
            <select name="category_id" id="category_id" required>
                <option value="">Sélectionnez une catégorie</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">Envoyer</button>
    </form>
@endsection