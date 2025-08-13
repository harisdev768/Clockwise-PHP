<?php
namespace App\Modules\User\Services;

use App\Modules\User\Models\Mappers\MetaMapper;


class MetaService{
    private MetaMapper $mapper;

    public function __construct(MetaMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function getAllUsers()
    {
        return $this->mapper->getUsers();
    }

    public function getAllDepartments(){
        return $this->mapper->getDepartments();
    }
    public function getAllJobRoles(){
        return $this->mapper->getJobRoles();
    }
    public function getAllLocations(){
        return $this->mapper->getLocations();
    }


}