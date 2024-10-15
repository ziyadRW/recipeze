<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'instructions', 'description', 'thumbnail_url', 'cook_time_minutes',
        'prep_time_minutes', 'num_servings', 'calories', 'nutrition', 'original_video_url'
    ];

    protected $casts = [
        'nutrition' => 'array',
    ];

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }
}
