<?php

namespace GooberBlox\Platform\Social\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use Cachable;
    protected $fillable = [
        'user_id',
        'friends_since'
    ];

    protected $casts = [
        'friends_since' => 'datetime'
    ];
}
