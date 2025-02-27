# Documentation - Relations Restaurant-Catégorie

## 1. Structure de la Relation
La relation est de type "One-to-Many" :
- Un restaurant peut avoir plusieurs catégories
- Une catégorie appartient à un seul restaurant

## 2. Étapes d'Implémentation

### Étape 1 : Migration dans la BDD
```php
// Dans database/migrations/create_categories_table.php
public function up()
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
        $table->timestamps();
    });
}
```

### Étape 2 : Adapter les Factory
```php
// Dans database/factories/CategoryFactory.php
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'restaurant_id' => random_int(1, 3)
        ];
    }
}
```

### Étape 3 : Adapter les Seeder
```php
// Dans database/seeders/DatabaseSeeder.php
public function run(): void
{
    Category::factory(10)->create();
}
```

### Étape 4 : Définir la Relation dans Restaurant Model
```php
// Dans app/Models/Restaurant.php
class Restaurant extends Model
{
    protected $table = "restaurants";
    protected $fillable = ["name"];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
```

### Étape 5 : Définir la Relation Inverse dans Category Model
```php
// Dans app/Models/Category.php
class Category extends Model
{
    protected $table = "categories";
    protected $fillable = ["name"];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
```

### Étape 6 : Exploiter les Relations dans les Views

#### Dans resources/views/categories/index.blade.php :
```php
@extends('layout.main')

@section('main')
    <h1>Categories</h1>
    <table border="1">
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
                    <td>{{ $category->restaurant->name }}</td>
                    <td>
                        <a href="{{ route('categories.show', $category->id) }}">Voir</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
```

#### Dans resources/views/categories/show.blade.php :
```php
@extends('layout.main')

@section('main')
    <h1>Categories</h1>
    <ul>
        <li>id : {{ $category->id }}</li>
        <li>nom : {{ $category->name }}</li>
    </ul>

    <h2>Restaurant : {{ $category->restaurant->name }}</h2>
    <a href="{{ route('restaurants.show', $category->restaurant->id) }}">
        Aller au restaurant {{ $category->restaurant->name }}
    </a>
@endsection
```

### Étape 7 : Contrôleur pour les Opérations CRUD
```php
// Dans app/Http/Controllers/CategoryController.php
class CategoryController extends Controller
{
    public function index() {
        return view('categories.index', [
            'categories' => Category::all()
        ]);
    }

    public function show($id) {
        return view('categories.show',
        ['category' => Category::findOrFail($id)]);
    }

    public function store(Request $request) {
        Category::create($request->all());
        return redirect()->route('categories.index');
    }

    public function update(Request $request, $id) {
        $category = Category::findOrFail($id);
        $category->name = $request->get('name');
        $category->save();
        return redirect()->route('categories.index');
    }

    public function destroy(Request $request, $id) {
        if($request->get('id') == $id) {
            Category::destroy($id);
        }
        return redirect()->route('categories.index');
    }
}
