<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class combinedUser extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'phone' => $this->phone,
            'url' => $this->url,
          
        ];

    }
}
