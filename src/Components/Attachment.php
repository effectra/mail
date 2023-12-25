<?php

declare(strict_types=1);

namespace Effectra\Mail\Components;

/**
 * Class Attachment
 *
 * Represents an email attachment with various properties.
 */
class Attachment
{
    public const HIDE_DATA = true;

    /**
     * Attachment constructor.
     *
     * @param string      $name     The name of the attachment.
     * @param string      $fileName The file name of the attachment.
     * @param string|null $type     The MIME type of the attachment.
     * @param string|null $id       The unique identifier of the attachment.
     * @param string|null $data     The base64-encoded data of the attachment.
     * @param string|null $path     The path to the file if available.
     */
    public function __construct(
        private string $name,
        private string $fileName = '',
        private ?string $type = null,
        private ?string $id = null,
        private ?string $data = null,
        private ?string $path = null,
    ) {
    }

    /**
     * Get the name of the attachment.
     *
     * @return string The name of the attachment.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the file name of the attachment.
     *
     * @return string The file name of the attachment.
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * Get the base64-encoded data of the attachment.
     *
     * @return string|null The base64-encoded data of the attachment.
     */
    public function getData(): ?string
    {
        return $this->data;
    }

    /**
     * Get the path to the file if available.
     *
     * @return string|null The path to the file if available.
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * Get the filename path to the file if available.
     * @throws \Exception If the save path is not provided.
     * @return string|null The path to the file if available.
     */
    public function getFileNamePath(): string
    {
        if (!$this->path) {
            throw new \Exception("Please add save path directory");
        }
        $ds = DIRECTORY_SEPARATOR;
        return trim($this->path, $ds) . $ds . $this->fileName;
    }

    /**
     * Set the name of the attachment.
     *
     * @param string $name The name of the attachment.
     *
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set the file name of the attachment.
     *
     * @param string $name The file name of the attachment.
     *
     * @return $this
     */
    public function setFileName(string $name): self
    {
        $this->fileName = $name;
        return $this;
    }

    /**
     * Set the path to the file.
     *
     * @param string $path The path to the file.
     *
     * @return $this
     */
    public function setPath(string $path): self
    {
        $this->path = $path;
        return $this;
    }

    /**
     * Set the data of the attachment from the file name and path.
     * @throws \Exception If the save path is not provided.
     * @return $this|false
     */
    public function setDataFromFileNameAndPath(): self|false
    {
        $file = $this->getFileNamePath();

        $contents = file_get_contents($file);
        if ($contents === false) {
            return false;
        }

        $base64 = base64_encode($contents);
        if ($base64 === false) {
            return false;
        }
        $this->data = $base64;

        return $this;
    }

    /**
     * Save the attachment to the specified path.
     *
     * @return int|false The number of bytes written to the file on success, or false on failure.
     *
     * @throws \Exception If the save path is not provided.
     */
    public function save(): int|false
    {

        return file_put_contents($this->getFileNamePath(), $this->data);
    }

    /**
     * check if attachment path is exists
     * @return bool return true if exists or false on failure
     */
    public function isPathExists(): bool
    {
        if (!$this->path || empty($this->path)) {
            return false;
        }
        return file_exists($this->path);
    }

    public function __toString()
    {
        return $this->getFileNamePath();
    }

    public function __debugInfo()
    {
        if(static::HIDE_DATA){
            $this->data  = null;
        }
    }
}
