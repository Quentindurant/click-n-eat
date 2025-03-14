@extends('layout.main')

@section('main')
    <h1>Creation category</h1>

    <a href="{{ route('categories.index') }}">Retour à la liste</a>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="name">Nom : </label>
            <input type="text" id="name" name="name" placeholder="Nom" class="form-control">
        </div>
        
        <div class="form-group mb-3">
            <label for="restaurant_id">Restaurant : </label>
            <select name="restaurant_id" id="restaurant_id" class="form-control">
                <option value="">Sélectionnez un restaurant</option>
                @foreach($restaurants as $restaurant)
                    <option value="{{ $restaurant->id }}">{{ $restaurant->name }}</option>
                @endforeach
            </select>
        </div>
        
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
@endsection
