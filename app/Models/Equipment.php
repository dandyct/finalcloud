<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Forzar el nombre de la tabla si la base de datos tiene 'equipments' (plural).
     * Laravel por convención busca la tabla 'equipment' (singular) si hay una
     * configuración o mismatched naming; con esto evitamos el error.
     */
    protected $table = 'equipments';

    protected $fillable = [
        'name',
        'sku',
        'description',
        'price_per_day',
        'status',
        'location',
        'stock',
        'image',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
        'metadata' => 'array',
    ];

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}