<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}
