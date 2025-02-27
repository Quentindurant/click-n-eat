@extends('layout.main')

@section('main')
    <h1>Modification item</h1>

    <a href="{{ route('items.index') }}">Retour à la liste</a>

    <form action="{{ route('items.update', $item->id) }}" method="POST">
        @csrf
        @method('put')
        <label for="name">Nom : </label>
        <input type="text" id="name" name="name" placeholder="Nom" value="{{ $item->name }}">
        <button type="submit">Envoyer</button>
    </form>
@endsection