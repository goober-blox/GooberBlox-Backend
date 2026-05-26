<?php
namespace GooberBlox\Platform\Social;

use Illuminate\Support\Carbon;
class FollowingDetails
{
    public function __construct(
        public int $userId,
        public int $followerUserId,
        public ?Carbon $followerSince,
    ) {
    }
}