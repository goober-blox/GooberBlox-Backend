<?php

namespace GooberBlox\Platform\Social\Enums;

/**
 * Represents a grouping of messages by their predefined query filter type.
 */
enum MessageTabType
{
    /**
     * Messages received in the user's inbox.
     */
    case Inbox;

    /**
     * Messages sent by the user.
     */
    case Sent;

    /**
     * Messages the user has archived from their inbox.
     */
    case Archive;
}