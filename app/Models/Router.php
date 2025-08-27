<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Router extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'location',
        'user_id',
        'ip',
        'username',
        'password',
        'contact',
        'type',
        'description',
        'map_adress',
        'map_long',
        'map_lat',
        'deleted_at',
    ];

    public function packages()
    {
        return $this->hasMany(Package::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
