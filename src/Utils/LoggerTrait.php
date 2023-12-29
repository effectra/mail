<?php

declare(strict_types=1);

namespace Effectra\Mail\Utils;

use Psr\Log\LoggerInterface;

/**
 * Trait LoggerTrait
 *
 * A trait providing logging capabilities using PSR-3 LoggerInterface.
 */
trait LoggerTrait
{
    /** @var LoggerInterface|null The logger instance. */
    private ?LoggerInterface $logger = null;

    /**
     * Get the logger instance.
     *
     * @return LoggerInterface|null The logger instance.
     */
    public function getLogger(): ?LoggerInterface
    {
        return $this->logger;
    }

    /**
     * Set the logger instance.
     *
     * @param LoggerInterface $logger The logger instance to set.
     * @return self
     */
    public function setLogger(LoggerInterface $logger): self
    {
        $this->logger = $logger;
        return $this;
    }

    /**
     * Start logging using the configured logger.
     *
     * @param string $str The log message.
     * @param int $level The log level.
     * @return void
     */
    public function startLog(string $str, int $level): void
    {
        $internalLogLevel = $this->mapDebugLevelToLogLevel($level);
        $this->logger->log($internalLogLevel, $str);
    }

    /**
     * Map PHPMailer debug level to PSR-3 log level.
     *
     * @param int $level The PHPMailer debug level.
     * @return string The corresponding PSR-3 log level.
     */
    private function mapDebugLevelToLogLevel(int $level): string
    {
        switch ($level) {
            case 0:
                return 'debug'; // or 'info' based on your preference
            case 1:
                return 'debug';
            case 2:
                return 'info';
            case 3:
                return 'notice';
            case 4:
                return 'warning';
            case 5:
                return 'error';
            default:
                return 'error';
        }
    }
}
