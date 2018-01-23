<?php
return [
    'Dwdm/Users' => [
        'Users' => [
            'components' => [
                'Dwdm/Users.Register' => ['actions' => ['register' => 'Crud.Add']],
                'Dwdm/Users.Login' => ['actions' => ['login' => 'CrudUsers.Login']],
            ]
        ]
    ],
];
