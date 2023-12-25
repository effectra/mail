<?php

declare(strict_types=1);

namespace Effectra\Mail\Factory;

use Effectra\Mail\Contracts\FullMailInterface;
use Effectra\Mail\FullMail;

/**
 * Class FullMailFactory
 *
 * Factory class for creating instances of FullMailInterface.
 */
class FullMailFactory
{
    /**
     * Create a new instance of FullMailInterface.
     *
     * @return FullMailInterface A new instance of FullMailInterface.
     */
    public function createMail(): FullMailInterface
    {
        return new FullMail();
    }
}
