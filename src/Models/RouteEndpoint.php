<?php

namespace Orbit\Saas\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class RouteEndpoint extends Model
{
    protected $guarded = [];

    /**
     * Get the parent endpointable model (Instance).
     */
    public function endpointable(): MorphTo
    {
        return $this->morphTo();
    }
}
