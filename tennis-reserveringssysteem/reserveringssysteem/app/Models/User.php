<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use function PHPSTORM_META\map;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname',
        'prefix',
        'lastname',
        'email',
        'password',
        'member',
        'roles_id',
        'clubs_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'users_reservations');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
