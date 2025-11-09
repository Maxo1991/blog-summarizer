<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class FetchException extends Exception
{
    protected $message = 'Failed to fetch the webpage.';
}
