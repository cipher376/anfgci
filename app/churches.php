<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class churches extends Model
{
    //

    public function address()
    {


return $this->belongsTo('App\location');


    }

    public function User()
    {


return $this->belongsTo('App\User');


    }


    public function church_photos()
    {


return $this->hasMany('App\church_photos');


    }


    public function church_services()
    {


return $this->hasMany('App\church_services');


    }
}
