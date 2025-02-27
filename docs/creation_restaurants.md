Documentation - Création de la fonctionnalité Restaurants

Ce document détaille les étapes pour mettre en place la gestion des restaurants dans l'application ClickAndEat.

Étapes de création :

1. Création de la migration pour la table restaurants
```bash
php artisan make:migration create_restaurants_table
```

2. Création du modèle Restaurant
```bash
php artisan make:model Restaurant
```

3. Création de la factory pour générer des données de test
```bash
php artisan make:factory RestaurantFactory
```

4. Migration et remplissage de la base de données
```bash
php artisan migrate:fresh --seed
```

5. Création du contrôleur pour les restaurants
```bash
php artisan make:controller RestaurantsController
```

6. Création des vues
- Créer un dossier restaurants dans resources/views
  - Créer index.blade.php (liste des restaurants)
  - Créer create.blade.php (formulaire de création)
  - Créer edit.blade.php (formulaire de modification)
  - Créer show.blade.php (détails d'un restaurant)

Structure des fichiers :

Migration (database/migrations/2025_01_29_105429_create_restaurants_table.php)
```php
Schema::create('restaurants', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});
```

Modèle (app/Models/Restaurant.php)
```php
class Restaurant extends Model
{
    use HasFactory;
    protected $table = "restaurants";
    protected $fillable = [
        'name',
    ];
}
```

Factory (database/factories/RestaurantFactory.php)
```php
public function definition(): array
{
    return [
        'name' => fake()->company(),
    ];
}
```

Seeder (database/seeders/DatabaseSeeder.php)
```php
public function run(): void
{
    Restaurant::factory(10)->create();
    Category::factory(10)->create();
}
```

Routes (routes/web.php)
```php
use App\Http\Controllers\RestaurantsController;

Route::get('/restaurants', [RestaurantsController::class, 'index'])->name('restaurants.index');
Route::get('/restaurants/{id}/show', [RestaurantsController::class, 'show'])->name('restaurants.show');
Route::get('/restaurants/create', [RestaurantsController::class, 'create'])->name('restaurants.create');
Route::post('/restaurants', [RestaurantsController::class, 'store'])->name('restaurants.store');
Route::get('/restaurants/{id}/edit', [RestaurantsController::class, 'edit'])->name('restaurants.edit');
Route::put('/restaurants/{id}/update', [RestaurantsController::class, 'update'])->name('restaurants.update');
Route::delete('/restaurants/{id}/destroy', [RestaurantsController::class, 'destroy'])->name('restaurants.destroy');
```

Controller (app/Http/Controllers/RestaurantsController.php)
```php
use App\Models\Restaurant;

class RestaurantsController extends Controller
{
    public function index(){
        $restaurants = Restaurant::all();
        return view("restaurants.index", ['restaurants' => $restaurants]);
    }

    public function create(){
        return view("restaurants.create");
    }

    public function store(Request $request){
        Restaurant::create($request->all());
        return redirect()->route("restaurants.index");
    }

    public function show($id){
        return view('restaurants.show', 
        ['restaurant' => Restaurant::findOrFail($id)]);
    }

    public function edit($id){
        return view('restaurants.edit',
         ['restaurant' => Restaurant::findOrFail($id)]);
    }

    public function update(Request $request, $id) {
        $restaurant = Restaurant::findOrFail($id);
        $restaurant->name = $request->get('name');
        $restaurant->save();
        return redirect()->route('restaurants.index');
    }

    public function destroy(Request $request, $id) {
        if($request->get('id') == $id) {
            Restaurant::destroy($id);
        }
        return redirect()->route('restaurants.index');
    }
}
```

Vue Liste (resources/views/restaurants/index.blade.php)
```php
@extends('layout.main')

@section('main')
    <h1>Restaurants</h1>

    <a href="{{ route('restaurants.create') }}">Créer un restaurant</a>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($restaurants as $restaurant)
                <tr>
                    <td>{{ $restaurant->id }}</td>
                    <td>{{ $restaurant->name }}</td>
                    <td>
                        <div style="display: flex;">
                            <a style="margin-right: 8px;" href="{{ route('restaurants.show', $restaurant->id) }}">Voir</a>
                            <a style="margin-right: 8px;" href="{{ route('restaurants.edit', $restaurant->id) }}">Modifier</a>
                            <form action="{{ route('restaurants.destroy', $restaurant->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="id" value="{{ $restaurant->id }}">
                                <button type="submit">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        console.log("scripts !");
    </script>
@endsection
```

Vue Création (resources/views/restaurants/create.blade.php)
```php
@extends('layout.main')

@section('main')
    <h1>Creation restaurant</h1>

    <a href="{{ route('restaurants.index') }}">Retour à la liste</a>

    <form action="{{ route('restaurants.store') }}" method="POST">
        @csrf
        <label for="name">Nom : </label>
        <input type="text" id="name" name="name" placeholder="Nom">
        <button type="submit">Envoyer</button>
    </form>
@endsection
```

Vue Edition (resources/views/restaurants/edit.blade.php)
```php
@extends('layout.main')

@section('main')
    <h1>Modification restaurant</h1>

    <a href="{{ route('restaurants.index') }}">Retour à la liste</a>

    <form action="{{ route('restaurants.update', $restaurant->id) }}" method="POST">
        @csrf
        @method('put')
        <label for="name">Nom : </label>
        <input type="text" id="name" name="name" placeholder="Nom" value="{{ $restaurant->name }}">
        <button type="submit">Envoyer</button>
    </form>
@endsection
```

Vue Détails (resources/views/restaurants/show.blade.php)
```php
@extends('layout.main')

@section('main')
    <h1>Restaurants</h1>

    <a href="{{ route('restaurants.index') }}">Retour à la liste</a>
    <a href="{{ route('restaurants.create') }}">Créer un restaurant</a>

    <ul>
        <li>id : {{ $restaurant->id }}</li>
        <li>nom : {{ $restaurant->name }}</li>
        <li>created_at : {{ $restaurant->created_at }}</li>
        <li>updated_at : {{ $restaurant->updated_at }}</li>
    </ul>
    
@endsection
```

Layout Principal (resources/views/layout/main.blade.php)
```php
<!DOCTYPE html>
<html lang="en">
@include('layout.head')
<body>
    
    @yield('main')

    @yield('scripts')
</body>
</html>
```

En-tête HTML (resources/views/layout/head.blade.php)
```php
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Click'n'Eat</title>
    @yield('styles')
</head>