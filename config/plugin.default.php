<?php
return [
    'App' => [
        'plugins' => [
            'Dwdm/Users' => [
                'controllers' => [
                    'users' => [
                        'components' => [
                            'Dwdm/Users.Register' => ['actions' => ['register' => 'Crud.Add']],
                            'Dwdm/Users.Login' => ['actions' => ['login' => 'CrudUsers.Login']],
                        ]
                    ]
                ],
            ]
        ],
    ],
];
