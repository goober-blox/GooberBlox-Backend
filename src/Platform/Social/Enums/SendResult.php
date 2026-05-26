<?php

namespace GooberBlox\Platform\Social\Enums;

/**
 * Represents the result of a message send operation.
 */
enum SendResult
{
    /**
     * The message being replied to does not exist or was not sent to the user sending the reply.
     */
    case UnauthorizedReply;

    /**
     * The sender has sent too many messages and has reached the flood checker limit.
     */
    case SenderFlooded;

    /**
     * The recipient has received too many messages and has reached the flood checker limit.
     */
    case RecipientFlooded;

    /**
     * The body of the message is too long.
     */
    case BodyTooLong;

    /**
     * The body of the message is null or empty.
     */
    case BodyIsBlank;

    /**
     * The subject of the message is null or empty.
     */
    case SubjectIsBlank;

    /**
     * The sender is not logged in.
     */
    case Login;

    /**
     * The recipient does not exist.
     */
    case BadRecipient;

    /**
     * The sender does not exist.
     */
    case BadSender;

    /**
     * The sender attempted to send the message to themselves.
     */
    case SentToSelf;

    /**
     * The recipient's privacy settings are too restrictive.
     */
    case RecipientPrivacySettingsTooHigh;

    /**
     * The sender's privacy settings are too restrictive.
     */
    case SenderPrivacySettingsTooHigh;

    /**
     * The sender must verify their email.
     */
    case VerifySenderEmail;

    /**
     * An unknown error occurred.
     */
    case UnknownError;

    /**
     * The message did not pass moderation.
     */
    case Moderated;

    /**
     * The message was sent successfully.
     */
    case Success;
}