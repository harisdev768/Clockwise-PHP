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
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE deleted = 0");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $usersCollection = new UserCollection();
        foreach ($rows as $row) {
            $usersCollection->add(UserHydrator::hydrateForCollection($row));
        }

        return $usersCollection;
    }

    public function getDepartments()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM departments");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $departmentsCollection = new DepartmentCollection();
        foreach ($rows as $row) {
            $departmentsCollection->add(MetaHydrator::hydrateDepartmentForCollection($row));
        }
        return $departmentsCollection;
    }

    public function getJobRoles()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM job_roles");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $jobRolesCollection = new JobRoleCollection();
        foreach ($rows as $row) {
            $jobRolesCollection->add(MetaHydrator::hydrateJobRoleForCollection($row));
        }

        return $jobRolesCollection;
    }
    public function getLocations()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM locations");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $locationsCollection = new LocationCollection();
        foreach ($rows as $row) {
            $locationsCollection->add(MetaHydrator::hydrateLocationForCollection($row));
        }

        return $locationsCollection;
    }

}
