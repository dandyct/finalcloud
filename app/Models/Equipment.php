<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Rental;
use App\Models\User;

class Equipment extends Model
{
    use HasFactory, SoftDeletes;

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
        'user_id',
    ];

    protected $casts = [
        'price_per_day' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    // Verifica si el equipo pertenece al usuario autenticado
    public function isOwnedBy($user)
    {
        if (!$user) return false;
        return $this->user_id === $user->id;
    }

    // Retorna la URL de acceso a la imagen (si usas storage/public)
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-equipment.png');
        }

        return asset('storage/' . $this->image);
    }
}
