<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Vehicle model - represents rental vehicles in the system
 * 
 * @property int $id
 * @property int $brand_id
 * @property string $name - Vehicle name/model
 * @property string $type - Vehicle category (Sedan, SUV, Coupe, etc.)
 * @property int $price - Daily rental price in VND
 * @property string $description - Vehicle description
 * @property string $status - available|rented|maintenance
 * @property string $image - Image URL or storage path
 * 
 * @property Brand $brand
 * @property Collection $reviews
 */
class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id',
        'name',
        'type',
        'price',
        'description',
        'status',
        'image',
    ];

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%');
        });

        $query->when($filters['category'] ?? null, function ($query, $category) {
            $query->where('type', $category);
        });

        $query->when($filters['price'] ?? null, function ($query, $price) {
            if ($price === 'under_1m') {
                $query->where('price', '<', 1000000);
            } elseif ($price === 'above_2m') {
                $query->where('price', '>', 2000000);
            }
        });
    }

    public function brand() { return $this->belongsTo(Brand::class); }
    public function reviews() { return $this->hasMany(Review::class); }
}