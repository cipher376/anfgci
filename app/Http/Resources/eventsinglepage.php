<?php

namespace App\Http\Resources;
use \App\Http\Controllers\ManageController;
use Illuminate\Http\Resources\Json\Resource;

class eventsinglepage extends Resource
{
    /**
     * 
     * 
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function __construct($resource, $page)
    {
        $this->resource = $resource;
        $this->page = $page;
        
    }
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
            'photos' =>ManageController::showEventPhotospage($this->eventID,$this->page),
            
           
          
        ];
    }
}
