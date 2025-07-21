<?php

namespace App\Modules\User\Models;

class UserLocation {

    private int $locationId;
    private string $locationName;

    public function __construct(int $locationId){
        $this->locationId = $locationId;
        if($locationId == 1) {
            $this->locationName = "Pakistan";
        } elseif($locationId == 2) {
            $this->locationName = "Serbia";
        } elseif($locationId == 3) {
            $this->locationName = "USA";
        }
    }
    public function getLocationId(): int {
        return $this->locationId;
    }
    public function getLocationName(): string { return $this->locationName; }
}
