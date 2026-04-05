# HnsPts for Flute CMS

A production-ready Flute CMS module for **CS 1.6 HNS Mix PTS statistics**.

It provides:

- public leaderboard page
- individual player profile page
- nickname and SteamID search
- sorting and pagination
- JSON API endpoints
- admin settings page
- page widget with top players

## Default routes

The public route is controlled by `Resources/config/hnspts.php`:

- `GET /hns-pts`
- `GET /hns-pts/player/{id}`
- `GET /api/hns-pts/top`
- `GET /api/hns-pts/player/{id}`
- `GET /admin/hns-pts`

If you change `route_prefix`, clear Flute cache afterwards.

## Installation

1. Copy the `HnsPts` folder to `app/Modules/HnsPts`
2. Enable the module in Flute CMS
3. Open `/admin/hns-pts`
4. Enter your database credentials and schema mapping
5. Save the settings
6. Clear cache if needed:

```bash
php flute cache:clear
php flute cache:warmup
```

## Configuration

Default config file:

- `Resources/config/hnspts.php`

Runtime admin settings are stored in:

- `storage/app/modules/hnspts/settings.json`

The JSON file overrides the default config and is safe to keep outside version-controlled module code.

## Expected schema

By default, the module is configured for a common HNS Mix schema:

- players table: `hns_players`
- PTS table: `hns_pts`
- player primary key: `id`
- player name: `name`
- player foreign key in PTS: `id`
- wins: `wins`
- losses: `loss`
- points: `pts`

You can change all of these in the admin page without editing PHP files.

## Theme integration

The public pages use `flute::layouts.app` and push content/styles into the theme stacks, which matches the standard Flute theme layout model.

## Notes

- No secrets are stored in the repository by default.
- Route configuration lives in the PHP config file, not in the admin override JSON.
- The widget is auto-registered from the `Widgets/` directory.
