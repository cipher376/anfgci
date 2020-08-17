<?php

namespace App\JsonApi\Profiles;

use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;

class Schema extends EloquentSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'profiles';

    /**
     * @var array|null
     */

   // protected $attributes = [
    //    'firstname',
    //    'lastname',
    //    'phone',
   // ];


    public function getAttributes($resource)
 {
     return [
        'firstname' => $resource->name,
       'lastname' => $resource->address,
         'created-at' => $resource->created_at->toAtomString(),
         'updated-at' => $resource->updated_at->toAtomString(),
    ];
}




    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        return [
            'users' => [
                self::SHOW_SELF => true,
                self::SHOW_RELATED => true,
            ]
        ];
    }

}

