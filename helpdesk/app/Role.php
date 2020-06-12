<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //

    const KLANT = "klant";
    const EERSTELIJNS_MEDEWERKER = "eerstelijnsmedewerker";
    const TWEEDELIJNS_MEDEWERKER = "tweedelijnsmedewerker";
    const ADMIN = "administrator";

    public function users() {
        return $this->hasMany('App\User');
    }
}
