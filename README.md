# HNS PTS for Flute CMS

Custom **Flute CMS** module for **CS 1.6 HNS Mix** statistics.

This module was built for projects that use **HNS Match System** style PTS data and want to display it inside a **Flute CMS** website as a public leaderboard, player profile pages, admin settings page, and top players widget.

## Related Projects

- [OpenHNS / HnsMatchSystem](https://github.com/OpenHNS/HnsMatchSystem) — base HNS Match System project used as the gameplay/statistics source idea.
- [Flute CMS](https://github.com/Flute-CMS/cms) — CMS platform this module is built for.

## Features

- public leaderboard page
- player profile page
- admin settings page
- top players widget
- configurable database connection
- configurable table and column mapping
- pagination and sorting
- top players summary cards
- database connection test from admin panel
- support for custom route prefix

## Routes

### Public
- `/mix-pts`

### Admin
- `/admin/hns-pts`

## What This Module Does

The module connects a Flute CMS website to an HNS PTS database and displays:

- overall player ranking
- total players count
- average PTS
- top players
- wins / losses / winrate
- player profile pages

It is useful for CS 1.6 HNS communities that already store match statistics and want to publish them on their website.

## Module Structure

```text
HnsPts/
├── Admin/
│   ├── Controllers/
│   ├── Resources/
│   ├── Screens/
│   └── routes.php
├── Http/
│   └── Controllers/
├── Providers/
├── Resources/
│   ├── config/
│   ├── lang/
│   └── views/
├── Services/
├── Widgets/
├── module.json
└── routes.php
```

## Installation

### 1. Copy the module

Place the module into your Flute CMS modules directory:

```text
app/Modules/HnsPts
```

### 2. Check module structure

Make sure the folder contains:

- `module.json`
- `Providers/`
- `Resources/`
- `Services/`
- `Http/`
- `Admin/`

### 3. Configure database connection

Edit:

```text
Resources/config/hnspts.php
```

Default example:

```php
return [
    'route_prefix' => '/mix-pts',

    'per_page' => 25,
    'max_per_page' => 100,
    'default_sort' => 'pts',
    'default_order' => 'desc',

    'db' => [
        'host' => '127.0.0.1',
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
        'steamid' => 'steamid',
        'ip' => 'ip',
        'playtime' => 'playtime',
        'lastconnect' => 'lastconnect',
    ],

    'widget' => [
        'title' => 'PTS Top',
        'limit' => 5,
        'show_wins' => false,
        'show_view_all' => false,
    ],
];
```

### 4. Clear cache

After installation or config changes:

```bash
php flute cache:clear
php flute cache:warmup
```

### 5. Open admin settings

Go to:

```text
/admin/hns-pts
```

There you can:

- test DB connection
- change table names
- change column mapping
- configure pagination
- configure widget settings

## Database Schema

By default the module is designed for a schema like this.

### `hns_players`
- `id`
- `name`
- `steamid`
- `ip`
- `playtime`
- `lastconnect`

### `hns_pts`
- `id`
- `wins`
- `loss`
- `pts`

You can remap field names in admin settings if your schema is different.

## Public Leaderboard

The public page shows:

- total players
- average PTS
- current leader
- maximum PTS
- top 3 players
- searchable and sortable leaderboard
- links to player profile pages

## Player Page

Each player page can show:

- nickname
- steamid
- ip
- playtime
- last connect
- wins
- losses
- winrate
- pts

## Admin Panel

The admin page allows you to configure:

- database host
- database port
- database name
- database username
- database password
- charset
- players table
- pts table
- column mapping
- default sort
- default order
- per-page value
- widget title
- widget limit
- widget options

## Widget

The module includes a top players widget.

Widget options:

- title
- players limit
- show wins
- show view all button

## Runtime Settings

Runtime settings can be stored in:

```text
storage/app/modules/hnspts/settings.json
```

This allows keeping repository config clean while using local production settings on the server.

## Integration Notes

### With HnsMatchSystem

This module is not a replacement for the original gameplay system.

It is intended to work **alongside** projects based on:

- [OpenHNS / HnsMatchSystem](https://github.com/OpenHNS/HnsMatchSystem)

The game server stores and updates player statistics, while this module reads those values and renders them in Flute CMS.

### With Flute CMS

This module is built specifically for:

- [Flute CMS](https://github.com/Flute-CMS/cms)

It uses Flute module structure, providers, resources, admin pages, views, and widget architecture.

## Repository Notes

Before publishing to GitHub:

- do not commit real database credentials
- do not commit production-only secrets
- keep `settings.json` local if it contains sensitive data
- rotate credentials if they were exposed during development

## Suggested .gitignore

```gitignore
.DS_Store
Thumbs.db
*.log
*.zip
*.tar.gz
.idea/
.vscode/
vendor/
node_modules/
.env
.env.*
*.local
storage/
```

## Screenshots

Recommended screenshots for the repository:

- leaderboard page
- player profile page
- admin settings page
- widget example

Example:

```md
![Leaderboard](screenshots/leaderboard.png)
![Player Profile](screenshots/player-profile.png)
![Admin Panel](screenshots/admin-panel.png)
```

## Use Case

Built for a **CS 1.6 HNS Mix** project that needed:

- public PTS rating
- player statistics pages
- top players block on website
- easy integration with Flute CMS
- configurable mapping for existing HNS database structure

## Tech Stack

- PHP
- Flute CMS
- Blade
- MySQL / MariaDB

## Repository Description

Flute CMS module for CS 1.6 HNS Mix PTS statistics with leaderboard, player profiles, widget, and admin settings.

## License

Add your preferred license here.
