<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trashcan extends Model
{
    protected $fillable = ['height', 'area', 'capacity', 'address', 'latitude', 'longitude'];

    public $timestamps = true;

    public function trashs()
    {
        return $this->hasMany('App\Trash');
    }
}
