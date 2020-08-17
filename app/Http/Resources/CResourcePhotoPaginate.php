<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class CResourcePhotoPaginate extends Resource
{



    private $page;

    public function __construct($resource,$page)
{
    // Ensure you call the parent constructor
    parent::__construct($resource);
    $this->resource = $resource; 
    $this->page= $page;
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
            'id' => $this->churchID,
            'name' => $this->name,
            'est_date' => $this->est_date,
            'country' => $this->country,
            'state' => $this->state,
            'town' => $this->town,
            'note' => stripslashes($this->note),
           // 'photos' => ManageController::showChurchPhotosPag($this->churchID,$this->page),
            
            
          
        ];
    }
}
