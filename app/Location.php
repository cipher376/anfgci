<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    protected $table = 'address';

    public function profile()
    {


return $this->hasMany('App\profile');


    }

    public function churches()
    {


return $this->hasMany('App\churches');


    }


    
}
