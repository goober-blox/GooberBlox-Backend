<?php

namespace GooberBlox\Platform\Social\Enums;

/**
 * Represents a privacy type that determines who can send a user a message.
 */
enum MessagePrivacyType
{
    /**
     * Any user can send the user a message.
     */
    case All;

    /**
     * Only best friends can send the user a message.
     */
    case TopFriends;

    /**
     * Only friends can send the user a message.
     */
    case Friends;

    /**
     * Nobody can send the user a message.
     */
    case NoOne;

    /**
     * No longer used - deprecated privacy type.
     */
    case Disabled;

    /**
     * Only friends and users the user is following can send the user a message.
     */
    case Following;

    /**
     * Only friends, users the user is following, and users following the user
     * can send the user a message.
     */
    case Followers;
}