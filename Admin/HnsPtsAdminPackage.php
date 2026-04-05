<?php

declare(strict_types=1);

namespace Flute\Modules\HnsPts\Admin;

use Flute\Admin\Support\AbstractAdminPackage;

class HnsPtsAdminPackage extends AbstractAdminPackage
{
    public function initialize(): void
    {
        parent::initialize();

        require_once __DIR__ . '/routes.php';
        $this->loadViews('Resources/views', 'admin-hnspts');
        $this->loadTranslations('../Resources/lang');
    }

    public function getPermissions(): array
    {
        return ['admin'];
    }

    public function getMenuItems(): array
    {
        return [
            [
                'type' => 'header',
                'title' => __('hnspts.admin.menu.header'),
            ],
            [
                'title' => __('hnspts.admin.menu.settings'),
                'icon' => 'ph.bold.chart-line-up-bold',
                'url' => url('/admin/hns-pts'),
                'permission' => 'admin',
            ],
        ];
    }

    public function getPriority(): int
    {
        return 55;
    }
}
