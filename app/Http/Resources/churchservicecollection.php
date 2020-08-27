<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use \App\Http\Controllers\ManageController;

class churchservicecollection extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
         
            'title' => $this->title,
            'date' => $this->month,
            'time' => $this->time,
          //'sermon'=>ManageController::showsermonUrl($this->sermonID),
          'sermonID'=>$this->sermonID,
        
           
          
        ];
    }
}
