<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
}
