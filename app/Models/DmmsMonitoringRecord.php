<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DmmsMonitoringRecord extends Model
{
    protected $fillable = [
        'farm_name', 'zone', 'temperature_c', 'humidity_pct', 'co2_ppm',
        'alert_message', 'recorded_at', 'notes',
    ];

    protected function casts(): array
    {
        return [
            'temperature_c' => 'decimal:2',
            'humidity_pct' => 'decimal:2',
            'co2_ppm' => 'integer',
            'recorded_at' => 'datetime',
        ];
    }
}
