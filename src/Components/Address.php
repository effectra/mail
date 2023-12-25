<?php

declare(strict_types=1);

namespace Effectra\Mail\Components;

/**
 * Class Address
 *
 * Represents an email address with an optional name.
 *
 * @package Effectra\Mail\Components
 */
class Address
{
    /**
     * @var string The name associated with the email address.
     */
    public function __construct(
        private readonly string $email,
        private readonly string $name = ''
    ) {
        if (!static::emailValidation($email)) {
            throw new \InvalidArgumentException("Invalid email address: '$email'", 1);
        }
    }

    /**
     * Create an Address instance from a string representation.
     *
     * @param string $addressText The string representation of the email address, optionally including a name.
     *
     * @return static An instance of the Address class.
     *
     * @throws \InvalidArgumentException If the provided email address is not valid.
     */
    public static function createFrom(string $addressText): static
    {

        if (preg_match('/^(?:([^<]+)<([^>]+)>|([^<>]+))$/', $addressText, $matches)) {
            $name = trim($matches[1]);
            $email = trim(!empty($matches[2]) ? $matches[2] : $matches[3]);
            return new static($email, $name);
        } else {
            $email = trim($addressText);
            $name = '';

            if (!static::emailValidation($email)) {
                throw new \InvalidArgumentException("Invalid email address: '$addressText'", 1);
            }

            return new static($email, $name);
        }
    }

    /**
     * Get the name associated with the email address.
     *
     * @return string The name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the email address.
     *
     * @return string The email address.
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Validate if an address is valid.
     *
     * @param string $email The email address to validate.
     * @return bool
     */
    public static function addressValidation(string $address): bool
    {
        if (preg_match('/^(?:[^<]+<[^>]+>|', $address, $matches)) {
            if (static::emailValidation($matches[2])) {
                return true;
            }
        }
        return false;
    }

    /**
     * Validate if an email address is valid.
     *
     * @param string $email The email address to validate.
     * @return bool
     */
    public static function emailValidation(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return false;
        }
        return true;
    }

    /**
     * Get the string representation of the Address.
     *
     * @return string The string representation.
     */
    public function format(): string
    {
        return sprintf('%s <%s>', $this->name, $this->email);
    }

    /**
     * Get the string representation of the Address if class called as string.
     *
     * @return string The string representation.
     */
    public function __toString(): string
    {
        return $this->format();
    }
}
