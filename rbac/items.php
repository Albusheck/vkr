<?php

return [
    'calculate' => [
        'type' => 2,
        'description' => 'Perform a calculation',
    ],
    'viewHistory' => [
        'type' => 2,
        'description' => 'View calculation history',
    ],
    'manageUsers' => [
        'type' => 2,
        'description' => 'Manage users',
    ],
    'viewAllCalculations' => [
        'type' => 2,
        'description' => 'View all users’ calculations',
    ],
    'guest' => [
        'type' => 1,
        'children' => [
            'calculate',
        ],
    ],
    'user' => [
        'type' => 1,
        'children' => [
            'calculate',
            'viewHistory',
        ],
    ],
    'administrator' => [
        'type' => 1,
        'children' => [
            'calculate',
            'viewHistory',
            'manageUsers',
            'viewAllCalculations',
        ],
    ],
];
