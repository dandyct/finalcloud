<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rental extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'rentals';

    protected $fillable = [
        'user_id',
        'equipment_id',
        'customer_name',
        'customer_contact',
        'start_date',
        'end_date',
        'price_total',
        'price_per_day',
        'status',
        'notes',
    ];

    protected $casts = [
        'price_total' => 'decimal:2',
        'price_per_day' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
