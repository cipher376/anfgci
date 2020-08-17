<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class profile extends Model
{
    //
    protected $table = 'profile';

public function photos()
    {


return $this->belongsTo('App\photos');


    }
    public function user()
    {


return $this->belongsTo('App\User');


    }

    

    public function address()
    {


return $this->belongsTo('App\location');


    }


}
