<?php

namespace App\Modules\User\Models;

class UserLocation {

    private int $locationId;
    private string $locationName;

    private array $locations = [
        1 => "Pakistan",
        2 => "Serbia",
        3 => "USA"
    ];

    public function __construct(int $locationId){
        $this->locationId = $locationId;
        $this->locationName = $this->locations[$locationId] ?? 'Unknown';
    }
    public function getLocationId(): int {
        return $this->locationId;
    }
    public function getLocationName(): string {
        return $this->locationName;
    }
}
