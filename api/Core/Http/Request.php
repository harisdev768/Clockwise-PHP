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
            // fallback to standard $_POST or $_GET
            $this->data = $_POST ?: $_GET;
        }
    }

    //Get all request data
    public function all(): array {
        return $this->data;
    }
    public function addUserId($id) {
        $this->data["user_id"] = $id; // Modifies the object's internal data
        return $this->data; // Returns the modified internal data
    }

    //Get specific key
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
