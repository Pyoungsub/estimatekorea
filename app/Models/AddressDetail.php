<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddressDetail extends Model
{
    //
    protected $guarded = [];
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
    public function extra_address()
    {
        return $this->belongsTo(ExtraAddress::class);
    }
}
