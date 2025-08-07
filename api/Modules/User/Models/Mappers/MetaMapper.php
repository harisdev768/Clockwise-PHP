<?php
namespace App\Modules\User\Models\Mappers;

use App\Modules\User\Exceptions\MetaException;
use App\Modules\User\Models\Collections\DepartmentCollection;
use App\Modules\User\Models\Collections\JobRoleCollection;
use App\Modules\User\Models\Collections\LocationCollection;
use App\Modules\User\Models\Hydrators\MetaHydrator;
use App\Modules\User\Models\Hydrators\UserHydrator;
use App\Modules\User\Models\User;
use App\Config\DB;
use App\Modules\User\Models\Collections\UserCollection;
use App\Modules\User\Models\UserId;
use PDO;

class MetaMapper
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = DB::getConnection();
    }


    public function getUsers()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($rows as $row) {
            if (!$row['deleted']) {
                $users[] = UserHydrator::hydrateForCollection($row);
            }
        }

        return new UserCollection($users);
    }

    public function getDepartments()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM departments");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $departments = [];

        foreach ($rows as $row) {
            $departments[] = MetaHydrator::hydrateDepartmentForCollection($row);
        }
        return new DepartmentCollection($departments);
    }

    public function getJobRoles()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM job_roles");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $jobroles = [];

        foreach ($rows as $row) {
            $jobroles[] = MetaHydrator::hydrateJobRoleForCollection($row);
        }

        return new JobRoleCollection($jobroles);
    }
    public function getLocations()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM locations");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $locations = [];

        foreach ($rows as $row) {
            $locations[] = MetaHydrator::hydrateLocationForCollection($row);
        }

        return new LocationCollection($locations);
    }

}
