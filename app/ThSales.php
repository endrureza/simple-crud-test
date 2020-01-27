<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ThSales extends Model
{
    protected $guarded = [];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(
            '\App\MCustomer',
            'customer_id'
        );
    }

    public function details(): HasMany
    {
        return $this->hasMany(
            '\App\TdSalesDetail',
            'sales_id'
        );
    }
}
