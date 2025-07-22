<?php
return [
    'roles' => [
        'Manager' => [
            'permissions' => [
                'add_user',
                'edit_user',
                'get_users',
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
    ],
];
