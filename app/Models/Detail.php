<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Detail
 *
 * @mixin Eloquent
 */

class Detail extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'address',
        'phone',
        'dob',
        'pin',
        'router_password',
        'package_name',
        'package_price',
        'package_start',
        'due',
        'status',
        'router_name',
        'deleted_at',
        'kkiapay_key',
        'stripe_key'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
