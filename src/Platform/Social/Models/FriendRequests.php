<?php

namespace GooberBlox\Platform\Social\Models;

use Illuminate\Database\Eloquent\Model;

class FriendRequests extends Model
{
    protected $fillable = [
        'sender_id',
        'recipient_id',
        'subject',
        'body',
        'sent_at',
        'is_accepted'
    ];

    protected $casts = [
        'sent_at' => 'datetime'
    ];
}
