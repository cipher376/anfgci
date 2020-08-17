<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class church extends Resource
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
            'id' => $this->churchID,
            'name' => $this->name,
            'est_date' => $this->est_date,
            'country' => $this->country,
            'state' => $this->state,
            'town' => $this->town,
          
        ];
    }
}
