<?php

declare(strict_types=1);

namespace Effectra\Mail\Contracts;

/**
 * Interface FullMailFactoryInterface
 */
interface FullMailFactoryInterface
{
    /**
     * Create a new instance of a mail object.
     *
     * @return FullMailInterface An instance of the FullMailInterface.
     */
    public function createMail(): FullMailInterface;
}
