<?php

declare(strict_types=1);

use Flute\Modules\HnsPts\Http\Controllers\PtsController;

$prefix = (string) config('hnspts.route_prefix', '/mix-pts');
$prefix = '/' . ltrim(trim($prefix), '/');
$prefix = rtrim($prefix, '/');
$prefix = $prefix === '' ? '/mix-pts' : $prefix;

router()->get($prefix, [PtsController::class, 'index'])->name('hnspts.index');
router()->get($prefix . '/player/{id}', [PtsController::class, 'player'])->name('hnspts.player');
router()->get('/api/hns-pts/top', [PtsController::class, 'apiTop'])->name('api.hnspts.top');
router()->get('/api/hns-pts/player/{id}', [PtsController::class, 'apiPlayer'])->name('api.hnspts.player');
