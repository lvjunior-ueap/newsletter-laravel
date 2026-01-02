<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscriber extends Model
{

    use HasFactory;

    protected $fillable = [
        'email',
        'active',
        'token',
        'confirmed_at',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
    ];

    public function isConfirmed(): bool
    {
        return !is_null($this->confirmed_at);
    }
}
