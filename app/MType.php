<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MType extends Model
{
    protected $guarded = [];

    public function cluster(): BelongsTo
    {
        return $this->belongsTo(
            '\App\MCluster'
        );
    }
}
