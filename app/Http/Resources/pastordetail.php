<?php

namespace App\Http\Resources;
use \App\Http\Controllers\ManageController;
use Illuminate\Http\Resources\Json\Resource;

class pastordetail extends Resource
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
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'photos' => $this->url,
            'country' => $this->country,
            'state' => $this->state,
            'town' => $this->town,
            'audios'=>ManageController::pastorAudios($this->id),
            'videos'=>ManageController::pastorVideos($this->id),
            'sermons'=>ManageController::pastorSermons($this->id),
            
          
        ];
    }
}
