<?php
return [
    'roles' => [
        'Manager' => [
            'permissions' => [
                'add_user',
                'edit_user',
                'get_users',
                'get_meta',
                'get_timesheet',
                'approve_timesheet',
            ],
        ],
        'Employee' => [
            'permissions' => [
            ],
        ],
    ],

    'permissions' => [
        'add_user',
        'edit_user',
        'get_users',
        'get_meta',
        'get_timesheet',
        'approve_timesheet',
    ],
];
