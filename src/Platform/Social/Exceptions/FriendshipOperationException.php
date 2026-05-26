<?php

namespace GooberBlox\Platform\Social\Exceptions;

use Exception;
use Throwable;

class FriendshipOperationException extends Exception
{
    public function __construct(string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}