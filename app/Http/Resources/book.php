<?php

namespace App\Http\Resources;
use \App\Http\Controllers\PastorController;
use Illuminate\Http\Resources\Json\Resource;

class book extends Resource
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
            'title' => $this->title,
            'detail' => $this->caption,
            'cover' => PastorController::showbookCover($this->id),
            'url' => $this->url,
            'author' => $this->artist,
          
        ];
    }
}
