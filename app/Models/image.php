<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    public $table = 'image';
    public $timestamps = false;

    public function author()
    {
        return $this->belongsTo('App\Models\event','event_id','id');
    }
}
