<?php
return [
    'roles' => [
        'Manager' => [
            'permissions' => [
                'add_user',
                'edit_user',
                'get_users',
                'clock_update',
                'break_update',
                'clock_status'
            ],
        ],
        'Employee' => [
            'permissions' => [
                'clock_update',
                'break_update',
                'clock_status'
            ],
        ],
    ],

    'permissions' => [
        'add_user',
        'edit_user',
        'get_users',
        'clock_update',
        'break_update',
        'clock_status'
    ],
];
