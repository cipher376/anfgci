<?php

namespace App\Http\Resources;
use \App\Http\Controllers\ManageController;
use Illuminate\Http\Resources\Json\Resource;

class eventsingle extends Resource
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
            'id' => $this->eventID,
            'title' => $this->title,
            'note' => $this->note,
            'startTime' => $this->startTime,
            'endTime' => $this->endTime,
            'postDate' => $this->created_at,
            'postedBy' => $this->author,
            'country' => $this->country,
            'state' => $this->state,
            'town' => $this->town,
            'photos' =>ManageController::showEventPhotos($this->eventID),
            
           
          
        ];
    }
}
