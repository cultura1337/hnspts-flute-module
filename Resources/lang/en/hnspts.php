<?php

declare(strict_types=1);

return [
    'admin' => [
        'screen' => [
            'title' => 'HNS PTS',
            'description' => 'HNS PTS module settings',
        ],
        'menu' => [
            'header' => 'HNS PTS',
            'settings' => 'PTS Settings',
        ],
        'buttons' => [
            'save' => 'Save',
            'test' => 'Test connection',
            'public_page' => 'Open public page',
        ],
        'sections' => [
            'database' => 'Database connection',
            'schema' => 'Tables and columns',
            'module' => 'Module settings',
            'widget' => 'Widget settings',
            'help' => 'Help',
        ],
        'fields' => [
            'host' => 'Host',
            'port' => 'Port',
            'database' => 'Database',
            'username' => 'Username',
            'password' => 'Password',
            'charset' => 'Charset',

            'table_players' => 'Players table',
            'table_pts' => 'PTS table',

            'column_player_pk' => 'Player PK',
            'column_player_name' => 'Player name column',
            'column_pts_player_fk' => 'PTS FK column',
            'column_wins' => 'Wins column',
            'column_losses' => 'Losses column',
            'column_pts' => 'PTS column',
            'column_steamid' => 'SteamID column',
            'column_ip' => 'IP column',
            'column_playtime' => 'Playtime column',
            'column_lastconnect' => 'Last connect column',

            'per_page' => 'Per page',
            'max_per_page' => 'Max per page',
            'default_sort' => 'Default sort',
            'default_order' => 'Default order',

            'widget_title' => 'Widget title',
            'widget_limit' => 'Players limit',
            'widget_show_wins' => 'Show wins',
            'widget_show_view_all' => 'Show "View all" button',
        ],
        'notes' => [
            'override' => 'Settings are saved into storage/app/modules/hnspts/settings.json',
            'route' => 'Public route is taken from route_prefix in config.',
            'widget' => 'Top players widget uses the same DB settings.',
        ],
        'messages' => [
            'saved' => 'Settings saved',
            'test_ok' => 'Database connection successful',
            'test_fail' => 'Database connection failed',
        ],
    ],
];
