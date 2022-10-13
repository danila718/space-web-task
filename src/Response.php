<?php

namespace Danila718\SpaceWebTask;

class Response
{
    private ?array $data = null;

    public function __construct(?array $data = null, $message = null)
    {
        if (empty($data)) {
            $this->data = ['error' => ['message' => $message ?? 'Empty response']];
        } else {
            $this->data = $data;
        }
    }

    /**
     * Return true if response has error
     *
     * @return bool
     */
    public function hasError(): bool
    {
        return !isset($this->data['result']) && isset($this->data['error']);
    }

    /**
     * Return response data
     *
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * Get result
     *
     * @return mixed
     */
    public function getResult()
    {
        return $this->data['result'] ?? null;
    }

    /**
     * Return error
     *
     * @return array|null
     */
    public function getError(): ?array
    {
        return $this->data['error'] ?? null;
    }

    /**
     * Return error code
     *
     * @return mixed
     */
    public function getErrorCode()
    {
        return $this->data['error']['code'] ?? null;
    }

    /**
     * Return error mesage
     *
     * @return string|null
     */
    public function getErrorMessage(): ?string
    {
        return $this->data['error']['message'] ?? null;
    }
}
