<?php

declare(strict_types=1);

use Flute\Core\Router\Router;
use Flute\Modules\HnsPts\Admin\Controllers\SettingsController;
use Flute\Modules\HnsPts\Admin\Screens\SettingsScreen;

Router::screen('/admin/hns-pts', SettingsScreen::class);

router()->post('/admin/hns-pts/test', [SettingsController::class, 'testConnection'])->name('admin.hnspts.test');
router()->post('/admin/hns-pts/save', [SettingsController::class, 'save'])->name('admin.hnspts.save');
