<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesRecord extends Model
{
    protected $fillable = [
        'customer_name', 'email', 'product_line', 'amount', 'payment_status', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }
}
