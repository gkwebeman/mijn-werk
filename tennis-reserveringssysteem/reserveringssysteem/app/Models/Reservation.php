<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'starttime',
        'endtime',
        'nameEvent',
    ];

    public function court()
    {
        return $this->belongsTo(Court::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_reservations');
    }
}
