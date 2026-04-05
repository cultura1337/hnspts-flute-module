<?php

declare(strict_types=1);

namespace Flute\Modules\HnsPts\Providers;

use DI\Container;
use Flute\Core\Support\ModuleServiceProvider;
use Flute\Modules\HnsPts\Admin\HnsPtsAdminPackage;
use Flute\Modules\HnsPts\Services\PtsService;

class HnsPtsProvider extends ModuleServiceProvider
{
    protected ?string $moduleName = 'HnsPts';

    public function register(Container $container): void
    {
        $container->set(PtsService::class, \DI\autowire());
    }

    public function boot(Container $container): void
    {
        $this->bootstrapModule();
        $this->loadViews('Resources/views', 'hnspts');
        $this->loadTranslations('Resources/lang');

        $themeViews = dirname(__DIR__, 3) . '/Themes/standard/views';
        if (is_dir($themeViews) && function_exists('view')) {
            view()->addNamespace('theme_standard', $themeViews);
        }

        require_once dirname(__DIR__) . '/routes.php';

        if (function_exists('is_admin_path') && is_admin_path()) {
            $this->loadPackage(new HnsPtsAdminPackage());
        }
    }
}
