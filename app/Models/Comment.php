<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Comment
 *
 * @mixin Eloquent
 */
class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['comment', 'user_id', 'ticket_id','deleted_at'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
