<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class sermonsingle extends Resource
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
            'id' => $this->sermonID,
            'title' => $this->title,
            'note' => $this->note,
            'timePosted' => $this->created_at,
            'file' => $this->url,
            'author' => $this->artist,
          
        ];
    }
}
