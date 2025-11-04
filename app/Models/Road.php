<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Road extends Model
{
    //
    protected $guarded = [];
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function extra_addresses()
    {
        return $this->hasMany(ExtraAddress::class);
    }
}
