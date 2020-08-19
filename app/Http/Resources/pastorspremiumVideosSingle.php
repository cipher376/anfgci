<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use \App\Http\Controllers\ManageController;

class pastorspremiumVideosSingle extends Resource
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
            'id' => $this->videoID,
            'type' => $this->vidType,
            'title' => $this->title,
            'author' => $this->artist,
            'note' => $this->note,
            'url' => ManageController::videoUrl($this->videoID),
            
            
          
        ];
    }
}
