<?php
namespace App\Modules\User\Models;

class UserId {
    private ?int $id = null;

    public function __construct(int $id) {
        $this->id = $id;
    }

    public function setUserId(int $id) {
        $this->id = $id;
    }
    public function getUserIdVal(): ?int {
        return $this->id;
    }
}
