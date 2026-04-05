<?php

declare(strict_types=1);

return [
    'route_prefix' => '/mix-pts',

    'per_page' => 25,
    'max_per_page' => 100,
    'default_sort' => 'pts',
    'default_order' => 'desc',

    'db' => [
        'host' => '172.17.0.1',
        'port' => 3306,
        'database' => 's3_pts',
        'username' => 'u3_NhzjcfZem1',
        'password' => 'UHrTCZ^@xHgl!Gf+b+79iSSV',
        'charset' => 'utf8mb4',
    ],

    'tables' => [
        'players' => 'hns_players',
        'pts' => 'hns_pts',
    ],

    'columns' => [
        'player_pk' => 'id',
        'player_name' => 'name',
        'pts_player_fk' => 'id',
        'wins' => 'wins',
        'losses' => 'loss',
        'pts' => 'pts',
    ],
];
