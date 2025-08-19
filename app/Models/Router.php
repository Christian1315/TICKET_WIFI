<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Router extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name', 'location', 'ip', 'username', 'password','deleted_at'];

    public function packages() {
        return $this->hasMany(Package::class);
    }
}
