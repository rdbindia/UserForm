<?php

namespace helpers;

class JsonResponse
{
    public function __construct(
        public readonly array $data,
        public readonly int $status = 200
    )
    {
    }

    public static function response(array $data, int $status = 200): self
    {
        return new self($data, $status);
    }

    public function toJson(): string|false
    {
        $response = [
            'status' => $this->status,
            'success' => $this->status >= 200 && $this->status < 300,
        ];
        return json_encode(array_merge($response, $this->data));
    }
    public function toArray(): array
    {
        $response = [
            'status' => $this->status,
            'success' => $this->status >= 200 && $this->status < 300,
        ];
        return array_merge($response, $this->data);
    }
}