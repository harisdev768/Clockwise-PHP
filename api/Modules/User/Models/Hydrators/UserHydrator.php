<?php

namespace App\Modules\User\Models\Hydrators;

use App\Modules\User\Models\Collections\UserCollection;
use App\Modules\User\Models\UserDepartment;
use App\Modules\User\Models\UserJobRole;
use App\Modules\User\Models\UserLocation;
use App\Modules\User\Models\UserRole;
use App\Modules\User\Request\AddUserRequest;
use App\Modules\User\Models\User;


class UserHydrator
{
    public function fromRequest(AddUserRequest $request): User
    {
        $user = new User();
        $user->setFirstName($request->firstName);
        $user->setLastName($request->lastName);
        $user->setEmail($request->email);
        $user->setUsername($request->username);
        $user->setPasswordHash(password_hash($request->password, PASSWORD_BCRYPT));
        return $user;
    }


    public static function hydrate(array $data): User
    {
        $user = new User();
        $user->setEmail($data['email']);
        return $user;
    }
    public static function hydrateListOfCollections(array $users = []): UserCollection
    {
        $userCollection = new UserCollection();
        foreach ($users as $user) {
            $userCollection->add($user);
        }
        return $userCollection;
    }

    public static function hydrateForCollection(array $data): User
    {

        $user = new User();
         $user->setUserId($data['id']);
         $user->setFirstName($data['first_name']);
         $user->setLastName($data['last_name']);
         $user->setEmail($data['email']);
         $user->setUsername($data['username']);
         $user->setCellPhone($data['cell_phone'] ?? "");
         $user->setHomePhone($data['home_phone'] ?? "");
         $user->setNickname($data['nickname'] ?? "");
         $user->setAddress($data['address'] ?? "");
         $user->setStatus($data['status']);
         $user->SetLocation(new UserLocation($data['location_id'] ?? 0));
         $user->setDepartment(new UserDepartment($data['department_id'] ?? 0));
         $user->setUserJobRole(new UserJobRole($data['job_role_id'] ?? 0));
         $user->setDeleted($data['deleted'] ?? false);
         $user->setrole( new UserRole($data['role_id']));
         $user->setCreatedAt($data['created_at']);
         $user->setLastLogin($data['last_login'] ?? "");
         return $user;
    }

    public static function hydrateFromArray(array $data): User{
        $user = new User();
        $user->setUserId($data['id']);
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setUsername($data['username']);
        $user->setEmail($data['email']);
        $user->setPasswordHash($data['password_hash']);
        $user->setStatus($data['status']);
        $user->setCreatedAt($data['created_at']);
        $user->setrole( new UserRole($data['role_id']));
        $user->setDeleted($data['deleted'] ?? false);
        return $user;
    }

}