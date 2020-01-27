<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MCluster extends Model
{
    protected $guarded = [];

    public function types(): HasMany
    {
        return $this->hasMany(
            '\App\MType',
            'cluster_id'
        );
    }
}
