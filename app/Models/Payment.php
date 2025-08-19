<?php

namespace App\Models;


use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * User
 *
 * @mixin Eloquent
 */
class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['billing_id', 'user_id', 'invoice', 'payment_method', 'package_price','deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function billing()
    {
        return $this->belongsTo(Billing::class);
    }
}
