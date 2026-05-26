<?php

namespace GooberBlox\Platform\Social\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Following extends Model
{
    use Cachable;
    protected $table = 'following';
    protected $fillable = [
        'user_id',
        'follower_user_id',
        'follower_since'
    ];
    protected $casts = [
        'follower_since' => 'datetime'
    ];

    /**
     * Returns follower count for current user, replica of IFriendsClient
     * @param int $userId
     * @return int
     */
    public static function getFollowersCount(int $userId): int
    {
        return self::where('user_id', $userId)->count();
    }

    /**
     * Returns following count for current user, replica of IFriendsClient
     * @param int $userId
     * @return int
     */
    public static function getFollowingsCount(int $userId): int
    {
        return self::where('follower_user_id', $userId)->count();
    }

    /**
     * Returns if userId is following requested user
     * @param int $userId
     * @return int
     */
    public static function followingExists(int $userId, int $followerUserId): bool
    {
        return self::where('user_id', $userId)
            ->where('follower_user_id', $followerUserId)
            ->exists();
    }
    /**
     * Returns following details for multiple users.
     *
     * @param int $userId
     * @param array<int> $otherUserIds
     * @return \Illuminate\Database\Eloquent\Collection<int, self>
     */
    public static function MultigetFollowingDetails(int $userId, array $otherUserIds)
    {
        return self::query()
            ->where('follower_user_id', $userId)
            ->whereIn('user_id', $otherUserIds)
            ->get();
    }

    /**
     * Gets users that the specified user is following.
     *
     * @param int $userId
     * @param int $startRowIndex
     * @param int $maximumRows
     * @return \Illuminate\Database\Eloquent\Collection<int, self>
     */
    public static function getFollowings(int $userId, int $startRowIndex, int $maximumRows)
    {
        return self::query()
            ->where('follower_user_id', $userId)
            ->skip($startRowIndex)
            ->take($maximumRows)
            ->get();
    }
        
    /**
     * Gets followers for the specified user.
     *
     * @param int $userId
     * @param int $startRowIndex
     * @param int $maximumRows
     * @return \Illuminate\Database\Eloquent\Collection<int, self>
     */
    public static function getFollowers(int $userId, int $startRowIndex, int $maximumRows)
    {
        return self::query()
            ->where('user_id', $userId)
            ->skip($startRowIndex)
            ->take($maximumRows)
            ->get();
    }
}
