<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class church_photos extends Model
{
    //



    public function churches()
    {


return $this->belongsTo('App\churches');


    }
}
