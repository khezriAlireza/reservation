<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function provider()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function availabilities()
    {
        return $this->hasMany(Availability::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}
