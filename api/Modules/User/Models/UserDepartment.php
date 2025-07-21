<?php

namespace App\Modules\User\Models;

class UserDepartment {

    private int $departmentId;
    private string $departmentName;

    private $departments = array(
        '1' => 'R&D'
    );

    public function __construct(int $departmentId){
        $this->departmentId = $departmentId;
        if($departmentId == 1) {
            $this->departmentName = "R&D";
        } elseif($departmentId == 2) {
            $this->departmentName = "Sales";
        } elseif($departmentId == 3) {
            $this->departmentName = "QA";
        } elseif($departmentId == 4) {
            $this->departmentName = "Customer Support";
        } elseif($departmentId == 5) {
            $this->departmentName = "Finance";
        }
    }
    public function getDepartmentId(): int {
        return $this->departmentId;
    }
    public function getDepartmentName(): string { return $this->departmentName; }
}
