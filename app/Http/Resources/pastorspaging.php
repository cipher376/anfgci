<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use \App\Http\Controllers\ManageController;
class pastorspaging extends Resource
{
    public function __construct($resource, $page)
    {
        $this->resource = $resource;
        $this->page = $page;
        
    }
   
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'photos' => $this->url,
            'country' => $this->country,
            'state' => $this->state,
            'town' => $this->town,
            'audios'=>ManageController::pastorAudiospaging($this->id,$this->page),
            'videos'=>ManageController::pastorVideospaging($this->id,$this->page),
            'sermons'=>ManageController::pastorSermonspaging($this->id,$this->page),
          
        ];
    }
}
