<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'type',
        'clubs_id',
    ];

    public function club()
    {
        $this->belongsTo(Club::class);
    }

    public function reservations()
    {
        $this->hasMany(Reservation::class);
    }
}
