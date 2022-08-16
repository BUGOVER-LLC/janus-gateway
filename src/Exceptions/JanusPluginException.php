<?php

declare(strict_types=1);

namespace Service\Janus\Exceptions;

use Exception;

class JanusPluginException extends Exception
{
    /**
     * JanusPluginException constructor.
     *
     * @param string $message
     */
    public function __construct(string $message = 'Janus Plugin Failed.')
    {
        parent::__construct($message);
    }
}
