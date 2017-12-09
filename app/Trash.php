<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trash extends Model
{
    protected $fillable = ['trashcanId', 'out', 'in', 'humidity', 'ultrawave', 'weight'];

    public $timestamps = true;

    public function trashcan() {
        return $this->belongsTo('App\Trashcan');
    }
}
