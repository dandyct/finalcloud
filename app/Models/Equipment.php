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
        'stock' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    // Una máquina puede tener muchas rentas
    public function rentals()
    {
        // IMPORTANTE:
        // ->withTrashed() permite acceder a rentas aunque la máquina se elimine con soft delete
        return $this->hasMany(Rental::class)->withTrashed();
    }

    // Dueño del equipo
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors / Helpers
    |--------------------------------------------------------------------------
    */

    // Imagen accesible públicamente
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-equipment.png');
        }

        return asset('storage/' . $this->image);
    }

    // Verificar si el dueño es el usuario autenticado
    public function isOwnedBy($user)
    {
        return $user && $this->user_id === $user->id;
    }

    // Verifica si hay stock disponible
    public function hasStock()
    {
        return $this->stock > 0;
    }
}