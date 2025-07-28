<?php
 namespace App\Modules\User\Models\Hydrators;

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

     public static function hydrate(array $data): User{
         $user = new User();
         $user->setEmail($data['email']);
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
