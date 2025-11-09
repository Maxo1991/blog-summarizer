<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class SummarizeException extends Exception
{
    protected $message = 'Failed to summarize the text.';
}
