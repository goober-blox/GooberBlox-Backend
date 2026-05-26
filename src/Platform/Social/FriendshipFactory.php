<?php

namespace GooberBlox\Platform\Social;

use GooberBlox\Platform\Core\Exceptions\PlatformArgumentException;
use GooberBlox\Platform\Social\Exceptions\FriendshipOperationException;
use Gooberblox\Platform\Social\Models\Following;
class FriendshipFactory {
    private static int $maxPageSizeAllowedForFriendshipOperations = config('gooberblox.social.Default.MaxPageSizeAllowedForFriendshipOperations');
    /*
    public function __construct(UserBlockAuthority $userBlockAuthority)
    {

    }
    */

    public function getFollowersCount(int $userId): int
    {
        if($userId < 0)
        {
            throw new PlatformArgumentException("Invalid parameters passed to GetFollowersCount. UserId:{$userId}");
        }

        try {
            return Following::getFollowersCount($userId);
        } catch(\Exception $e) {
            throw new FriendshipOperationException($e->getMessage());
        }
    }

    public function getFollowingCount(int $userId): int
    {
        if($userId < 0)
        {
            throw new PlatformArgumentException("Invalid parameters passed to GetFollowersCount. UserId:{$userId}");
        }

        try {
            return Following::getFollowingCount($userId);
        } catch(\Exception $e) {
            throw new FriendshipOperationException($e->getMessage());
        }
    }

    public function hasFollower(int $userId, int $followerUserId)
    {
        if($userId <= 0 || $followerUserId <= 0)
        {
            throw new PlatformArgumentException("Invalid parameters passed to GetFollowersCount. UserId:{$userId}");
        }

        try {
            return Following::followingExists($userId, $followerUserId);
        } catch(\Exception $e) {
            throw new FriendshipOperationException($e->getMessage());
        }
    }

    public function multigetFollowingDetails(int $userId, array $otherUserIds): array 
    {
        if(count($otherUserIds) > config('gooberblox.social.Default.MaxMultigetFollowingExistsCount'))
        {
            throw new PlatformArgumentException("You cannot request more than ". config('gooberblox.social.Default.MaxMultigetFollowingExistsCount') ." following exists at once.");
        }

        if($userId <=  0 || collect($otherUserIds)->contains(fn (int $id) => $id <= 0))
        {
            throw new PlatformArgumentException("Invalid parameters passed to MultigetFollowingDetails. All UserIds must be positive.");
        }

        try { 
            return collect(Following::MultigetFollowingDetails($userId, $otherUserIds))
            ->map(fn (Following $following) => new FollowingDetails(
                    $following->user_id,
                    $following->follower_user_id,
                    $following->follower_since,
                ))
                ->all();
        } catch(\Exception $e) {
            throw new FriendshipOperationException($e->getMessage());
        }
    }

    /**
     * @deprecated Use GetFollowersEnumerative
     */
    public function getFollowers(int $userId, int $startRowIndex, int $maximumRows)
    {
        if($userId <=  0 || $startRowIndex <= 0 || $maximumRows <= 0)
        {
            throw new PlatformArgumentException("Invalid parameters passed to getFollowings. UserId:{$userId},StartRowIndex:{$startRowIndex},MaximumRows:{$maximumRows}");
        }
        $maximumRows = (($maximumRows > $this->maxPageSizeAllowedForFriendshipOperations) ? $this->maxPageSizeAllowedForFriendshipOperations : $maximumRows);

        try {
            return collect(Following::getFollowers($userId, $startRowIndex, $maximumRows))
                ->map(fn (Following $following) => new FollowingDetails($following->user_id, $following->follower_user_id, $following->follower_since))
                ->all();
        } catch(\Exception $e) {
            throw new FriendshipOperationException($e->getMessage());
        }
    }

    /**
     * @deprecated Use GetFollowingsEnumerative
     */
    public function getFollowings(int $userId, int $startRowIndex, int $maximumRows)
    {
        if($userId <=  0 || $startRowIndex <= 0 || $maximumRows <= 0)
        {
            throw new PlatformArgumentException("Invalid parameters passed to getFollowings. UserId:{$userId},StartRowIndex:{$startRowIndex},MaximumRows:{$maximumRows}");
        }
        $maximumRows = (($maximumRows > $this->maxPageSizeAllowedForFriendshipOperations) ? $this->maxPageSizeAllowedForFriendshipOperations : $maximumRows);

        try {
            return collect(Following::getFollowings($userId, $startRowIndex, $maximumRows))
                ->map(fn (Following $following) => new FollowingDetails($following->user_id, $following->follower_user_id, $following->follower_since))
                ->all();
        } catch(\Exception $e) {
            throw new FriendshipOperationException($e->getMessage());
        }
    }
}