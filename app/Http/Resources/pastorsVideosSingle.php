<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class pastorsVideosSingle extends Resource
{

    private $video;

    public function __construct($resource,$video)
{
    // Ensure you call the parent constructor
    parent::__construct($resource);
    $this->resource = $resource; 
    $this->video = $video;


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
            'id' => $this->videoID,
            'type' => $this->vidType,
            'photoCover' => $this->url,
            'title' => $this->title,
            'note' => $this->note,
            'url' => $this->video,
           
            
          
        ];
    }
}
