<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitlistEntry extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['consented_at' => 'datetime'];
    }
}
