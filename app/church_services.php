<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class church_services extends Model
{
    //


    public function churches()
    {


return $this->belongsTo('App\churches');


    }
}
