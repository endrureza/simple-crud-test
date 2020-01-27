<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TdSalesDetail extends Model
{
    protected $guarded = [];

    public function cluster(): BelongsTo
    {
        return $this->belongsTo(
            '\App\MCluster',
            'cluster_id'
        );
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(
            '\App\MType',
            'type_id'
        );
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(
            '\App\ThSales',
            'sales_id'
        );
    }
}
