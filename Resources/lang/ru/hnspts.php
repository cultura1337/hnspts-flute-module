<?php

declare(strict_types=1);

return [
    'admin' => [
        'screen' => [
            'title' => 'HNS PTS',
            'description' => 'Настройки модуля HNS PTS',
        ],
        'menu' => [
            'header' => 'HNS PTS',
            'settings' => 'Настройки PTS',
        ],
        'buttons' => [
            'save' => 'Сохранить',
            'test' => 'Проверить подключение',
            'public_page' => 'Открыть публичную страницу',
        ],
        'sections' => [
            'database' => 'Подключение к базе данных',
            'schema' => 'Схема таблиц и колонок',
            'module' => 'Параметры модуля',
            'widget' => 'Параметры виджета',
            'help' => 'Подсказки',
        ],
        'fields' => [
            'host' => 'Host',
            'port' => 'Port',
            'database' => 'Database',
            'username' => 'Username',
            'password' => 'Password',
            'charset' => 'Charset',

            'table_players' => 'Таблица игроков',
            'table_pts' => 'Таблица PTS',

            'column_player_pk' => 'PK игрока',
            'column_player_name' => 'Колонка ника',
            'column_pts_player_fk' => 'FK в таблице PTS',
            'column_wins' => 'Колонка побед',
            'column_losses' => 'Колонка поражений',
            'column_pts' => 'Колонка PTS',
            'column_steamid' => 'Колонка SteamID',
            'column_ip' => 'Колонка IP',
            'column_playtime' => 'Колонка времени в игре',
            'column_lastconnect' => 'Колонка последнего входа',

            'per_page' => 'Игроков на страницу',
            'max_per_page' => 'Максимум на страницу',
            'default_sort' => 'Сортировка по умолчанию',
            'default_order' => 'Порядок по умолчанию',

            'widget_title' => 'Заголовок виджета',
            'widget_limit' => 'Количество игроков',
            'widget_show_wins' => 'Показывать победы',
            'widget_show_view_all' => 'Показывать кнопку "Смотреть все"',
        ],
        'notes' => [
            'override' => 'Настройки сохраняются в storage/app/modules/hnspts/settings.json',
            'route' => 'Публичный маршрут берётся из route_prefix в конфиге.',
            'widget' => 'Виджет top players использует те же настройки БД.',
        ],
        'messages' => [
            'saved' => 'Настройки сохранены',
            'test_ok' => 'Подключение к БД успешно',
            'test_fail' => 'Ошибка подключения к БД',
        ],
    ],
];
