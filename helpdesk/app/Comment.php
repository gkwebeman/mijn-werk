<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    public function submitting_user() {
        return $this->belongsTo("App\User", "user_id");
    }

    public function ticket() {
        return $this->belongsTo("App\Ticket");
    }
}
