<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $fillable = ['recipe_id', 'name', 'quantity', 'unit'];

    public static function getAllUniqueIngredients()
    {
        $ingredients = Ingredient::select('name')
            ->distinct()
            ->orderBy('name', 'asc')
            ->paginate(100);

        return $ingredients;
    }

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }


}

