<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'timeslot',
        'amountOfReservations',
    ];

    public function club()
    {
        return $this->hasOne(Club::class);
    }

    public function timeslot()
    {
        return $this->belongsTo(Timeslot::class);
    }

    public function reservationkinds()
    {
        return $this->hasMany(ReservationKind::class, 'reservation_kind');
    }
}
