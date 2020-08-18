<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use \App\Http\Controllers\ManageController;

class pastorsAudioSingle extends Resource
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
            'id' => $this->audioID,
            'type' => $this->audioType,
            'title' => $this->title,
            'author' => $this->artist,
            'photoCover' => $this->url,
            'note' => $this->note,
            'url' => ManageController::audiosFile($this->audioID),
            
            
          
        ];
    }
}
