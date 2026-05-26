<?php

namespace GooberBlox\Platform\Social\Enums;
/**
 * Represents the status of a friendship between users.
 */
enum FriendshipStatus 
{
    /** 
    *  There is no friendship among the users.
    */
    case NoFriendship;
    /** 
    *  The current user has sent a friend request and the request is pending.
    */
    case PendingOnOtherUser;
    /** 
    *  The other user has sent a friend request and the request is pending.
    */
    case PendingOnCurrentUser;
    /** 
    *  The users are friends with each other.
    */
    case Friends;
}
