<?php

namespace App\JsonApi\Users;

use CloudCreativity\LaravelJsonApi\Schema\EloquentSchema;

class Schema extends EloquentSchema
{

    /**
     * @var string
     */
    protected $resourceType = 'users';

    /**
     * @var array|null
     */

    protected $attributes = [
        'name',
        'email',
    ];


    public function getRelationships($resource, $isPrimary, array $includeRelationships)
{
    return [
        'profiles' => [
            self::SHOW_SELF => true,
            self::SHOW_RELATED => true,
        ]
    ];
}

}

