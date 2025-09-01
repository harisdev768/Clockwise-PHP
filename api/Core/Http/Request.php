<?php

namespace App\Core\Http;

class Request {
    private array $routeParams = [];
    private array $data;

    public function __construct() {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        if (stripos($contentType, 'application/json') !== false) {
            $raw = file_get_contents("php://input");
            $decoded = json_decode($raw, true);
            $this->data = is_array($decoded) ? $decoded : [];
        } else {
            $this->data = $_POST ?: $_GET;
        }
    }

    public function all(): array {
        return $this->data;
    }
    public function addUserId($id) {
        $this->data["user_id"] = $id;
        return $this->data;
    }

    public function get(string $key, mixed $default = null): mixed {
        return $this->data[$key] ?? $default;
    }

    public function setRouteParams(array $params): void
    {
        $this->routeParams = $params;
    }

    public function getRouteParams(): array
    {
        return $this->routeParams;
    }

}
