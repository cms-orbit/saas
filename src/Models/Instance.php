<?php

namespace Orbit\Saas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Instance extends Model
{
    protected $guarded = [];

    /**
     * Get the container name/slug this instance belongs to.
     */
    public function getContainerSlug(): string
    {
        return $this->container_slug;
    }

    /**
     * Get the routes associated with this instance.
     */
    public function routes(): MorphMany
    {
        return $this->morphMany(RouteEndpoint::class, 'endpointable');
    }
}
