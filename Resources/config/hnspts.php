<?php

declare(strict_types=1);

return [
    'route_prefix' => '/mix-pts',

    'per_page' => 25,
    'max_per_page' => 100,
    'default_sort' => 'pts',
    'default_order' => 'desc',

    'db' => [
        'host' => '',
        'port' => 3306,
        'database' => '',
        'username' => '',
        'password' => '',
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
