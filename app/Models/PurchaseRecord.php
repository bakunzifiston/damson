<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRecord extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'product_interest', 'quantity', 'unit', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
        ];
    }
}
