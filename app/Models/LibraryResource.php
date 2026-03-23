<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibraryResource extends Model
{
    protected $fillable = [
        'category', 'title', 'description', 'resource_type', 'file_path', 'external_url',
    ];
}
