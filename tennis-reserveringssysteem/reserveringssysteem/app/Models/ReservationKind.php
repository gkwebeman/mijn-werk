<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationKind extends Model
{
    use HasFactory;

    protected $table = 'reservation_kind';

    protected $fillable = [
        'name',
    ];

    public function setting()
    {
        return $this->belongsTo(Setting::class, 'reservation_kind');
    }
}
