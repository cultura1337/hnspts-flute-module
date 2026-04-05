<?php

declare(strict_types=1);

namespace Flute\Modules\HnsPts\Services;

use PDO;
use PDOException;
use RuntimeException;

class PtsService
{
    private array $config;

    public function __construct()
    {
        $this->config = $this->loadConfig();
    }

    public function getConfigSnapshot(): array
    {
        return $this->config;
    }

    public function getPublicRoute(): string
    {
        $prefix = trim((string) ($this->config['route_prefix'] ?? '/hns-pts'));
        $prefix = $prefix === '' ? '/hns-pts' : ('/' . ltrim($prefix, '/'));

        return rtrim($prefix, '/') ?: '/hns-pts';
    }

    public function normalizeSettings(array $input): array
    {
        $current = $this->config;

        return [
            'db' => [
                'host' => trim((string) ($input['db']['host'] ?? $current['db']['host'] ?? '127.0.0.1')),
                'port' => max(1, (int) ($input['db']['port'] ?? $current['db']['port'] ?? 3306)),
                'database' => trim((string) ($input['db']['database'] ?? $current['db']['database'] ?? '')),
                'username' => trim((string) ($input['db']['username'] ?? $current['db']['username'] ?? '')),
                'password' => (string) ($input['db']['password'] ?? $current['db']['password'] ?? ''),
                'charset' => trim((string) ($input['db']['charset'] ?? $current['db']['charset'] ?? 'utf8mb4')),
            ],
            'tables' => [
                'players' => trim((string) ($input['tables']['players'] ?? $current['tables']['players'] ?? 'hns_players')),
                'pts' => trim((string) ($input['tables']['pts'] ?? $current['tables']['pts'] ?? 'hns_pts')),
            ],
            'columns' => [
                'player_pk' => trim((string) ($input['columns']['player_pk'] ?? $current['columns']['player_pk'] ?? 'id')),
                'player_name' => trim((string) ($input['columns']['player_name'] ?? $current['columns']['player_name'] ?? 'name')),
                'pts_player_fk' => trim((string) ($input['columns']['pts_player_fk'] ?? $current['columns']['pts_player_fk'] ?? 'id')),
                'wins' => trim((string) ($input['columns']['wins'] ?? $current['columns']['wins'] ?? 'wins')),
                'losses' => trim((string) ($input['columns']['losses'] ?? $current['columns']['losses'] ?? 'loss')),
                'pts' => trim((string) ($input['columns']['pts'] ?? $current['columns']['pts'] ?? 'pts')),
                'steamid' => trim((string) ($input['columns']['steamid'] ?? $current['columns']['steamid'] ?? 'steamid')),
                'ip' => trim((string) ($input['columns']['ip'] ?? $current['columns']['ip'] ?? 'ip')),
                'playtime' => trim((string) ($input['columns']['playtime'] ?? $current['columns']['playtime'] ?? 'playtime')),
                'lastconnect' => trim((string) ($input['columns']['lastconnect'] ?? $current['columns']['lastconnect'] ?? 'lastconnect')),
            ],
            'per_page' => max(1, min(100, (int) ($input['per_page'] ?? $current['per_page'] ?? 25))),
            'max_per_page' => max(1, min(200, (int) ($input['max_per_page'] ?? $current['max_per_page'] ?? 100))),
            'default_sort' => $this->normalizeSort((string) ($input['default_sort'] ?? $current['default_sort'] ?? 'pts')),
            'default_order' => $this->normalizeOrder((string) ($input['default_order'] ?? $current['default_order'] ?? 'desc')),
            'widget' => [
                'title' => trim((string) ($input['widget']['title'] ?? $current['widget']['title'] ?? 'PTS Top')),
                'limit' => max(1, min(20, (int) ($input['widget']['limit'] ?? $current['widget']['limit'] ?? 5))),
                'show_wins' => $this->toBool($input['widget']['show_wins'] ?? $current['widget']['show_wins'] ?? true),
                'show_view_all' => $this->toBool($input['widget']['show_view_all'] ?? $current['widget']['show_view_all'] ?? true),
            ],
        ];
    }

    public function validateSettings(array $settings): array
    {
        $errors = [];

        foreach (['host', 'database', 'username'] as $key) {
            if ($settings['db'][$key] === '') {
                $errors['db.' . $key] = __('hnspts.admin.validation.required');
            }
        }

        foreach (['players', 'pts'] as $key) {
            if ($settings['tables'][$key] === '') {
                $errors['tables.' . $key] = __('hnspts.admin.validation.required');
            }
        }

        foreach (['player_pk', 'player_name', 'pts_player_fk', 'wins', 'losses', 'pts'] as $key) {
            if ($settings['columns'][$key] === '') {
                $errors['columns.' . $key] = __('hnspts.admin.validation.required');
            }
        }

        return $errors;
    }

    public function saveSettings(array $settings): string
    {
        $path = (string) ($this->config['override_path'] ?? '');
        if ($path === '') {
            throw new RuntimeException('Override path is not configured.');
        }

        $dir = dirname($path);
        if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
            throw new RuntimeException('Unable to create settings directory: ' . $dir);
        }

        $payload = json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($payload === false) {
            throw new RuntimeException('Unable to encode settings JSON.');
        }

        if (file_put_contents($path, $payload) === false) {
            throw new RuntimeException('Unable to write settings file: ' . $path);
        }

        return $path;
    }

    public function testConnection(?array $settings = null): array
    {
        $config = $this->mergeRuntimeSettings($settings ?? []);
        $pdo = $this->createPdo($config['db']);

        $playersTable = $config['tables']['players'];
        $ptsTable = $config['tables']['pts'];

        $playersCount = (int) $pdo->query(sprintf('SELECT COUNT(*) FROM `%s`', $playersTable))->fetchColumn();
        $ptsCount = (int) $pdo->query(sprintf('SELECT COUNT(*) FROM `%s`', $ptsTable))->fetchColumn();

        return [
            'success' => true,
            'message' => __('hnspts.admin.messages.test_success'),
            'players_count' => $playersCount,
            'pts_count' => $ptsCount,
        ];
    }

    public function getSummary(): array
    {
        $m = $this->map();
        $pdo = $this->db();

        $sql = "
            SELECT
                COUNT(*) AS total_players,
                COALESCE(ROUND(AVG(s.`{$m['pts']}`), 0), 0) AS avg_pts,
                COALESCE(MAX(s.`{$m['pts']}`), 0) AS max_pts
            FROM `{$m['players_table']}` p
            INNER JOIN `{$m['pts_table']}` s
                ON p.`{$m['player_pk']}` = s.`{$m['pts_player_fk']}`
        ";

        $summary = $pdo->query($sql)->fetch() ?: [
            'total_players' => 0,
            'avg_pts' => 0,
            'max_pts' => 0,
        ];

        $leader = $this->getTop(1);
        $summary['leader_name'] = $leader[0]['name'] ?? '—';

        return $summary;
    }

    public function getTop(int $limit = 3): array
    {
        $m = $this->map();
        $pdo = $this->db();
        $limit = max(1, min(20, $limit));

        $sql = "
            SELECT
                p.`{$m['player_pk']}` AS id,
                p.`{$m['player_name']}` AS name,
                {$m['steamid_select']} AS steamid,
                {$m['playtime_select']} AS playtime,
                {$m['lastconnect_select']} AS lastconnect,
                s.`{$m['pts']}` AS pts,
                s.`{$m['wins']}` AS wins,
                s.`{$m['losses']}` AS losses,
                ROUND(
                    CASE
                        WHEN (s.`{$m['wins']}` + s.`{$m['losses']}`) > 0
                            THEN (s.`{$m['wins']}` * 100.0 / (s.`{$m['wins']}` + s.`{$m['losses']}`))
                        ELSE 0
                    END,
                    1
                ) AS winrate
            FROM `{$m['players_table']}` p
            INNER JOIN `{$m['pts_table']}` s
                ON p.`{$m['player_pk']}` = s.`{$m['pts_player_fk']}`
            ORDER BY s.`{$m['pts']}` DESC, s.`{$m['wins']}` DESC, p.`{$m['player_name']}` ASC
            LIMIT {$limit}
        ";

        return $pdo->query($sql)->fetchAll() ?: [];
    }

    public function getLeaderboard(int $page, int $perPage, string $search, string $sort, string $order): array
    {
        $m = $this->map();
        $pdo = $this->db();

        $page = max(1, $page);
        $perPage = max(1, min((int) ($this->config['max_per_page'] ?? 100), $perPage));
        $offset = ($page - 1) * $perPage;
        $sort = $this->normalizeSort($sort);
        $orderSql = strtoupper($this->normalizeOrder($order));

        $sortMap = [
            'pts' => "s.`{$m['pts']}`",
            'wins' => "s.`{$m['wins']}`",
            'losses' => "s.`{$m['losses']}`",
            'name' => "p.`{$m['player_name']}`",
        ];

        $where = '';
        $params = [];
        if ($search !== '') {
            $where = "WHERE p.`{$m['player_name']}` LIKE :q OR {$m['steamid_where']}";
            $params['q'] = '%' . $search . '%';
        }

        $countSql = "
            SELECT COUNT(*)
            FROM `{$m['players_table']}` p
            INNER JOIN `{$m['pts_table']}` s
                ON p.`{$m['player_pk']}` = s.`{$m['pts_player_fk']}`
            {$where}
        ";
        $countStmt = $pdo->prepare($countSql);
        $countStmt->execute($params);
        $total = (int) $countStmt->fetchColumn();

        $sql = "
            SELECT
                p.`{$m['player_pk']}` AS id,
                p.`{$m['player_name']}` AS name,
                {$m['steamid_select']} AS steamid,
                {$m['playtime_select']} AS playtime,
                {$m['lastconnect_select']} AS lastconnect,
                s.`{$m['pts']}` AS pts,
                s.`{$m['wins']}` AS wins,
                s.`{$m['losses']}` AS losses,
                ROUND(
                    CASE
                        WHEN (s.`{$m['wins']}` + s.`{$m['losses']}`) > 0
                            THEN (s.`{$m['wins']}` * 100.0 / (s.`{$m['wins']}` + s.`{$m['losses']}`))
                        ELSE 0
                    END,
                    1
                ) AS winrate
            FROM `{$m['players_table']}` p
            INNER JOIN `{$m['pts_table']}` s
                ON p.`{$m['player_pk']}` = s.`{$m['pts_player_fk']}`
            {$where}
            ORDER BY {$sortMap[$sort]} {$orderSql}, s.`{$m['wins']}` DESC, p.`{$m['player_name']}` ASC
            LIMIT {$perPage} OFFSET {$offset}
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        return [
            'items' => $stmt->fetchAll() ?: [],
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'offset' => $offset,
            'last_page' => max(1, (int) ceil($total / $perPage)),
        ];
    }

    public function getPlayer(int $id): ?array
    {
        $m = $this->map();
        $pdo = $this->db();

        $sql = "
            SELECT
                p.`{$m['player_pk']}` AS id,
                p.`{$m['player_name']}` AS name,
                {$m['steamid_select']} AS steamid,
                {$m['ip_select']} AS ip,
                {$m['playtime_select']} AS playtime,
                {$m['lastconnect_select']} AS lastconnect,
                s.`{$m['pts']}` AS pts,
                s.`{$m['wins']}` AS wins,
                s.`{$m['losses']}` AS losses,
                ROUND(
                    CASE
                        WHEN (s.`{$m['wins']}` + s.`{$m['losses']}`) > 0
                            THEN (s.`{$m['wins']}` * 100.0 / (s.`{$m['wins']}` + s.`{$m['losses']}`))
                        ELSE 0
                    END,
                    1
                ) AS winrate
            FROM `{$m['players_table']}` p
            INNER JOIN `{$m['pts_table']}` s
                ON p.`{$m['player_pk']}` = s.`{$m['pts_player_fk']}`
            WHERE p.`{$m['player_pk']}` = :id
            LIMIT 1
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    private function loadConfig(): array
    {
        $config = config('hnspts') ?? [];
        $overridePath = (string) ($config['override_path'] ?? '');

        if ($overridePath !== '' && is_file($overridePath)) {
            $payload = json_decode((string) file_get_contents($overridePath), true);
            if (is_array($payload)) {
                $config = array_replace_recursive($config, $payload);
            }
        }

        return $config;
    }

    private function mergeRuntimeSettings(array $settings): array
    {
        return array_replace_recursive($this->config, $settings);
    }

    private function db(): PDO
    {
        return $this->createPdo($this->config['db']);
    }

    private function createPdo(array $db): PDO
    {
        try {
            return new PDO(
                sprintf(
                    'mysql:host=%s;port=%d;dbname=%s;charset=%s',
                    $db['host'],
                    (int) $db['port'],
                    $db['database'],
                    $db['charset'] ?? 'utf8mb4'
                ),
                $db['username'],
                $db['password'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            throw new RuntimeException(__('hnspts.errors.database_unavailable') . ' ' . $e->getMessage(), 0, $e);
        }
    }

    private function map(): array
    {
        $columns = $this->config['columns'];

        return [
            'players_table' => $this->config['tables']['players'],
            'pts_table' => $this->config['tables']['pts'],
            'player_pk' => $columns['player_pk'],
            'player_name' => $columns['player_name'],
            'pts_player_fk' => $columns['pts_player_fk'],
            'wins' => $columns['wins'],
            'losses' => $columns['losses'],
            'pts' => $columns['pts'],
            'steamid_select' => $this->optionalSelect('p', $columns['steamid'] ?? ''),
            'ip_select' => $this->optionalSelect('p', $columns['ip'] ?? ''),
            'playtime_select' => $this->optionalSelect('p', $columns['playtime'] ?? ''),
            'lastconnect_select' => $this->optionalSelect('p', $columns['lastconnect'] ?? ''),
            'steamid_where' => $this->optionalWhereLike('p', $columns['steamid'] ?? '', ':q'),
        ];
    }

    private function optionalSelect(string $tableAlias, string $column): string
    {
        return $column !== '' ? sprintf('%s.`%s`', $tableAlias, $column) : 'NULL';
    }

    private function optionalWhereLike(string $tableAlias, string $column, string $param): string
    {
        return $column !== '' ? sprintf('%s.`%s` LIKE %s', $tableAlias, $column, $param) : '1 = 0';
    }

    private function normalizeSort(string $sort): string
    {
        return in_array($sort, ['pts', 'wins', 'losses', 'name'], true) ? $sort : 'pts';
    }

    private function normalizeOrder(string $order): string
    {
        return strtolower($order) === 'asc' ? 'asc' : 'desc';
    }

    private function toBool(mixed $value): bool
    {
        if (is_bool($value)) {
            return $value;
        }

        if (is_string($value)) {
            return in_array(strtolower($value), ['1', 'true', 'yes', 'on'], true);
        }

        return (bool) $value;
    }
}
