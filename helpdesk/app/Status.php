<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    //
    const EERSTELIJNS_WACHT = "Eerstelijns Wacht";
    const EERSTELIJNS_TOEGEWEZEN = "Eerstelijns Toegewezen";
    const TWEEDELIJNS_WACHT = "Tweedelijns Wacht";
    const TWEEDELIJNS_TOEGEWEZEN = "Tweedelijns Toegewezen";
    const AFGEHANDELD = "Afgehandeld";

    public function tickets() {
        return $this->hasMany("App\Ticket");
    }
}
