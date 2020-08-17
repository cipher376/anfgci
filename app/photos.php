<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class photos extends Model
{
    //




    public function profile()
    {


return $this->hasOne('App\profile','photoID');


    }
}
