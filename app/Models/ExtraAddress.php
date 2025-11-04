<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraAddress extends Model
{
    //
    protected $guarded = [];
    public function road()
    {
        return $this->belongsTo(Road::class);
    }
    public function address_details()
    {
        return $this->hasMany(AddressDetail::class);
    }
}
