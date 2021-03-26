<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'service_station_create',
            ],
            [
                'id'    => 18,
                'title' => 'service_station_edit',
            ],
            [
                'id'    => 19,
                'title' => 'service_station_show',
            ],
            [
                'id'    => 20,
                'title' => 'service_station_delete',
            ],
            [
                'id'    => 21,
                'title' => 'service_station_access',
            ],
            [
                'id'    => 22,
                'title' => 'user_alert_create',
            ],
            [
                'id'    => 23,
                'title' => 'user_alert_show',
            ],
            [
                'id'    => 24,
                'title' => 'user_alert_delete',
            ],
            [
                'id'    => 25,
                'title' => 'user_alert_access',
            ],
            [
                'id'    => 26,
                'title' => 'service_access',
            ],
            [
                'id'    => 27,
                'title' => 'car_create',
            ],
            [
                'id'    => 28,
                'title' => 'car_edit',
            ],
            [
                'id'    => 29,
                'title' => 'car_show',
            ],
            [
                'id'    => 30,
                'title' => 'car_delete',
            ],
            [
                'id'    => 31,
                'title' => 'car_access',
            ],
            [
                'id'    => 32,
                'title' => 'repair_create',
            ],
            [
                'id'    => 33,
                'title' => 'repair_edit',
            ],
            [
                'id'    => 34,
                'title' => 'repair_show',
            ],
            [
                'id'    => 35,
                'title' => 'repair_delete',
            ],
            [
                'id'    => 36,
                'title' => 'repair_access',
            ],
            [
                'id'    => 37,
                'title' => 'part_create',
            ],
            [
                'id'    => 38,
                'title' => 'part_edit',
            ],
            [
                'id'    => 39,
                'title' => 'part_show',
            ],
            [
                'id'    => 40,
                'title' => 'part_delete',
            ],
            [
                'id'    => 41,
                'title' => 'part_access',
            ],
            [
                'id'    => 42,
                'title' => 'task_create',
            ],
            [
                'id'    => 43,
                'title' => 'task_edit',
            ],
            [
                'id'    => 44,
                'title' => 'task_show',
            ],
            [
                'id'    => 45,
                'title' => 'task_delete',
            ],
            [
                'id'    => 46,
                'title' => 'task_access',
            ],
            [
                'id'    => 47,
                'title' => 'upcoming_create',
            ],
            [
                'id'    => 48,
                'title' => 'upcoming_edit',
            ],
            [
                'id'    => 49,
                'title' => 'upcoming_show',
            ],
            [
                'id'    => 50,
                'title' => 'upcoming_delete',
            ],
            [
                'id'    => 51,
                'title' => 'upcoming_access',
            ],
            [
                'id'    => 52,
                'title' => 'profile_password_edit',
            ],
        ];

        Permission::insert($permissions);
    }
}
