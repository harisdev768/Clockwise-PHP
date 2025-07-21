<?php

namespace App\Modules\User\Models;

class UserJobRole {

    private int $JobRoleId;
    private string $JobRoleName;

    public function __construct(int $JobRoleId){
        $this->JobRoleId = $JobRoleId;
        if($JobRoleId == 1) {
            $this->JobRoleName = "Manager";
        } elseif($JobRoleId == 2) {
            $this->JobRoleName = "HR";
        } elseif($JobRoleId == 3) {
            $this->JobRoleName = "Software Engineer";
        } elseif($JobRoleId == 4) {
            $this->JobRoleName = "Product Honor";
        } elseif($JobRoleId == 5) {
            $this->JobRoleName = "Intern";
        } elseif($JobRoleId == 6) {
            $this->JobRoleName = "SQA";
        } elseif($JobRoleId == 7) {
            $this->JobRoleName = "Team Lead";
        } elseif($JobRoleId == 8) {
            $this->JobRoleName = "Department Head";
        }
    }
    public function getJobRoleId(): int {
        return $this->JobRoleId;
    }
    public function getJobRoleName(): string { return $this->JobRoleName; }
}
