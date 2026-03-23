<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncubationRecord extends Model
{
    protected $fillable = [
        'batch_reference', 'species', 'incubation_start', 'expected_fruit', 'phase', 'observations',
    ];

    protected function casts(): array
    {
        return [
            'incubation_start' => 'date',
            'expected_fruit' => 'date',
        ];
    }
}
