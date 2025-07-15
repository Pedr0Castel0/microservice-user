<?php

namespace App\Models;

use App\Enums\SpiceLevel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dish extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'image_url',
        'ingredients',
        'spice_level',
        'is_available'
    ];

    protected $casts = [
        'ingredients' => 'array',
        'is_available' => 'boolean',
        'price' => 'decimal:2',
        'spice_level' => SpiceLevel::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
