<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class ExtractException extends Exception
{
    protected $message = 'Failed to extract text from HTML.';
}
