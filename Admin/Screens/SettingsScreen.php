<?php

declare(strict_types=1);

namespace Flute\Modules\HnsPts\Admin\Screens;

use Flute\Admin\Platform\Layouts\LayoutFactory;
use Flute\Admin\Platform\Screen;

class SettingsScreen extends Screen
{
    public ?string $name = 'HNS PTS';
    public ?string $description = 'Настройки модуля HNS PTS';
    public ?string $permission = 'admin';

    public array $settings = [];

    public function mount(): void
    {
        $base = config('hnspts') ?? [];
        $override = [];

        $path = BASE_PATH . '/storage/app/modules/hnspts/settings.json';

        if (is_file($path)) {
            $json = json_decode((string) file_get_contents($path), true);
            if (is_array($json)) {
                $override = $json;
            }
        }

        $this->settings = array_replace_recursive($base, $override);

        if (function_exists('breadcrumb')) {
            breadcrumb()
                ->add('Admin Panel', '/admin')
                ->add('HNS PTS');
        }
    }

    public function commandBar(): array
    {
        return [];
    }

    public function layout(): array
    {
        $routePrefix = (string) config('hnspts.route_prefix', '/mix-pts');
        $publicUrl = '/' . ltrim($routePrefix, '/');

        return [
            LayoutFactory::view('admin-hnspts::settings', [
                'settings' => $this->settings,
                'publicUrl' => $publicUrl,
            ]),
        ];
    }
}
