<?php

declare(strict_types=1);

namespace Flute\Modules\HnsPts\Admin\Controllers;

use PDO;
use PDOException;

class SettingsController
{
    private function ensureAdmin(): void
    {
        if (!function_exists('user') || !user() || !user()->can('admin')) {
            abort(403);
        }
    }

    private function configPath(): string
    {
        return BASE_PATH . '/storage/app/modules/hnspts/settings.json';
    }

    private function baseConfig(): array
    {
        return config('hnspts') ?? [];
    }

    private function loadOverride(): array
    {
        $path = $this->configPath();

        if (!is_file($path)) {
            return [];
        }

        $json = json_decode((string) file_get_contents($path), true);
        return is_array($json) ? $json : [];
    }

    private function settings(): array
    {
        return array_replace_recursive($this->baseConfig(), $this->loadOverride());
    }

    private function persist(array $payload): void
    {
        $settings = $this->settings();

        $settings['db']['host'] = (string) ($payload['db_host'] ?? $settings['db']['host'] ?? '127.0.0.1');
        $settings['db']['port'] = (int) ($payload['db_port'] ?? $settings['db']['port'] ?? 3306);
        $settings['db']['database'] = (string) ($payload['db_database'] ?? $settings['db']['database'] ?? '');
        $settings['db']['username'] = (string) ($payload['db_username'] ?? $settings['db']['username'] ?? '');
        $settings['db']['password'] = (string) ($payload['db_password'] ?? $settings['db']['password'] ?? '');
        $settings['db']['charset'] = (string) ($payload['db_charset'] ?? $settings['db']['charset'] ?? 'utf8mb4');

        $settings['tables']['players'] = (string) ($payload['table_players'] ?? $settings['tables']['players'] ?? 'hns_players');
        $settings['tables']['pts'] = (string) ($payload['table_pts'] ?? $settings['tables']['pts'] ?? 'hns_pts');

        $settings['columns']['player_pk'] = (string) ($payload['column_player_pk'] ?? $settings['columns']['player_pk'] ?? 'id');
        $settings['columns']['player_name'] = (string) ($payload['column_player_name'] ?? $settings['columns']['player_name'] ?? 'name');
        $settings['columns']['pts_player_fk'] = (string) ($payload['column_pts_player_fk'] ?? $settings['columns']['pts_player_fk'] ?? 'id');
        $settings['columns']['wins'] = (string) ($payload['column_wins'] ?? $settings['columns']['wins'] ?? 'wins');
        $settings['columns']['losses'] = (string) ($payload['column_losses'] ?? $settings['columns']['losses'] ?? 'loss');
        $settings['columns']['pts'] = (string) ($payload['column_pts'] ?? $settings['columns']['pts'] ?? 'pts');
        $settings['columns']['steamid'] = (string) ($payload['column_steamid'] ?? $settings['columns']['steamid'] ?? 'steamid');
        $settings['columns']['ip'] = (string) ($payload['column_ip'] ?? $settings['columns']['ip'] ?? 'ip');
        $settings['columns']['playtime'] = (string) ($payload['column_playtime'] ?? $settings['columns']['playtime'] ?? 'playtime');
        $settings['columns']['lastconnect'] = (string) ($payload['column_lastconnect'] ?? $settings['columns']['lastconnect'] ?? 'lastconnect');

        $settings['per_page'] = (int) ($payload['per_page'] ?? $settings['per_page'] ?? 25);
        $settings['max_per_page'] = (int) ($payload['max_per_page'] ?? $settings['max_per_page'] ?? 100);
        $settings['default_sort'] = (string) ($payload['default_sort'] ?? $settings['default_sort'] ?? 'pts');
        $settings['default_order'] = (string) ($payload['default_order'] ?? $settings['default_order'] ?? 'desc');

        $settings['widget']['title'] = (string) ($payload['widget_title'] ?? $settings['widget']['title'] ?? 'PTS Top');
        $settings['widget']['limit'] = (int) ($payload['widget_limit'] ?? $settings['widget']['limit'] ?? 5);
        $settings['widget']['show_wins'] = !empty($payload['widget_show_wins']);
        $settings['widget']['show_view_all'] = !empty($payload['widget_show_view_all']);

        file_put_contents(
            $this->configPath(),
            json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        );
    }

    private function testDb(array $settings): void
    {
        $db = $settings['db'] ?? [];

        new PDO(
            sprintf(
                'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                $db['host'] ?? '127.0.0.1',
                (int) ($db['port'] ?? 3306),
                $db['database'] ?? '',
                $db['charset'] ?? 'utf8mb4'
            ),
            $db['username'] ?? '',
            $db['password'] ?? '',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
    }

    public function index()
    {
        $this->ensureAdmin();

        return view('admin-hnspts::settings', [
            'title' => 'HNS PTS',
            'settings' => $this->settings(),
            'publicUrl' => url((string) (config('hnspts.route_prefix', '/mix-pts'))),
        ]);
    }

    public function testConnection()
    {
        $this->ensureAdmin();

        $payload = request()->all();
        $this->persist($payload);
        $settings = $this->settings();

        try {
            $this->testDb($settings);

            return redirect('/admin/hns-pts')->with('success', __('hnspts.admin.messages.test_ok'));
        } catch (PDOException $e) {
            return redirect('/admin/hns-pts')->with('error', __('hnspts.admin.messages.test_fail') . ': ' . $e->getMessage());
        }
    }

    public function save()
    {
        $this->ensureAdmin();

        $this->persist(request()->all());

        return redirect('/admin/hns-pts')->with('success', __('hnspts.admin.messages.saved'));
    }
}
