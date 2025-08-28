<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Billing
 *
 * @mixin Eloquent
 */
class Billing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice',
        // 'package_name',
        // 'package_price',
        // 'package_start',
        'package_id',
        'user_id',
        'deleted_at',
        "price",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, "package_id");
    }

    public function tickets():HasMany
    {
        return  $this->hasMany(Ticket::class);
    }

    /**
     * Reste à payer sur une facture
     */
    public function resteToPay()
    {
        return $this->price - ($this->payment ? $this->payment->package_price : 0);
    }

    public function generateRandomNumber()
    {
        try {
            $number = random_int(100000, 999999);
        } catch (\Exception $e) {
        }

        if (self::where('invoice', $number)->exists()) {
            return $this->generateRandomNumber();
        }
        return $number;
    }
}
