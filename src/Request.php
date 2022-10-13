<?php

namespace Danila718\SpaceWebTask;

use Exception;

class Request
{
    private ?string $url = null;
    private array $headers = [];
    private string $method = 'GET';
    private array $body = [];

    /**
     * Set url
     *
     * @param string $url
     * @return $this
     */
    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get url
     *
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * Set headers
     *
     * @param array $headers
     * @return $this
     */
    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * Get headers array
     *
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Get method
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get body
     *
     * @return array
     */
    public function getBody(): array
    {
        return $this->body;
    }

    /**
     * Set body
     *
     * @param array $body
     */
    public function setBody(array $body): void
    {
        $this->body = $body;
    }

    /**
     * Set method to POST and add post data
     *
     * @param array $data
     * @return $this
     */
    public function post(array $data): self
    {
        $this->method = 'POST';
        $this->setBody($data);
        return $this;
    }

    /**
     * Send curl request
     *
     * @return Response
     * @throws Exception
     */
    public function send(): Response
    {
        $ch = $this->prepare();
        if (!$result = curl_exec($ch)) {
            return new Response(null, 'Error sending request');
        }
        $result = json_decode($result, true);
        if (!is_array($result)) {
            return new Response();
        }
        return new Response($result);
    }

    /**
     * Preparing curl
     *
     * @return false|resource
     */
    private function prepare()
    {
        if (isset($this->body)) {
            $encodeBody = json_encode(array_merge([
                'jsonrpc' => '2.0',
                'version' => '1.151.20221010132004',
            ], $this->body));
        }

        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);

        if ($this->method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
        }

        $headers = array_merge($this->headers, [
            'Accept: application/json'
        ]);
        if (isset($encodeBody)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodeBody);
            $headers = array_merge($headers, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($encodeBody),
            ]);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        return $ch;
    }
}
