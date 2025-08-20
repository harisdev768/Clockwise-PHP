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
                'clock_status',
                'add_note',
                'get_meta',
            ],
        ],
        'Employee' => [
            'permissions' => [
                'clock_update',
                'break_update',
                'clock_status',
                'add_note'
            ],
        ],
    ],

    'permissions' => [
        'add_user',
        'edit_user',
        'get_users',
        'clock_update',
        'break_update',
        'clock_status',
        'add_note',
        'get_meta',
    ],
];
