<?php

declare(strict_types=1);

namespace Jobcloud\HttpMockServer;

final class Response implements \JsonSerializable
{
    /**
     * @var int
     */
    private $status = 200;

    /**
     * @var array<string, string>
     */
    private $headers = [];

    /**
     * @var string
     */
    private $body = '';

    private function __construct()
    {
    }

    /**
     * @return self
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * @param int $status
     *
     * @return self
     */
    public function withStatus(int $status): self
    {
        $clone = clone $this;
        $clone->status = $status;

        return $clone;
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return self
     */
    public function withHeader(string $name, string $value): self
    {
        $clone = clone $this;
        $clone->headers[$name] = $value;

        return $clone;
    }

    /**
     * @param string $body
     *
     * @return self
     */
    public function withBody(string $body): self
    {
        $clone = clone $this;
        $clone->body = $body;

        return $clone;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'status' => $this->status,
            'headers' => $this->headers,
            'body' => $this->body,
        ];
    }

    /**
     * @param array $data
     *
     * @return self
     */
    public static function createFromArray(array $data): self
    {
        $self = self::create();
        $self->status = $data['status'] ?? $self->status;
        $self->headers = $data['headers'] ?? $self->headers;
        $self->body = $data['body'] ?? $self->body;

        return $self;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return array<string, string>
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }
}
