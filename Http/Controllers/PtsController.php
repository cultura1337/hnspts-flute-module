<?php

declare(strict_types=1);

namespace Flute\Modules\HnsPts\Http\Controllers;

use Flute\Modules\HnsPts\Services\PtsService;
use Throwable;

class PtsController
{
    public function __construct(
        private readonly PtsService $ptsService
    ) {
    }

    public function index()
    {
        $page = max(1, (int) request()->get('page', 1));
        $query = trim((string) request()->get('q', ''));
        $sort = trim((string) request()->get('sort', config('hnspts.default_sort', 'pts')));
        $order = trim((string) request()->get('order', config('hnspts.default_order', 'desc')));
        $perPage = (int) config('hnspts.per_page', 25);

        try {
            $summary = $this->ptsService->getSummary();
            $top3 = $this->ptsService->getTop(3);
            $players = $this->ptsService->getLeaderboard($page, $perPage, $query, $sort, $order);
            $errorMessage = null;
        } catch (Throwable $e) {
            logs()->error('HNS PTS leaderboard failed to load', ['exception' => $e]);
            $summary = ['total_players' => 0, 'avg_pts' => 0, 'max_pts' => 0, 'leader_name' => '—'];
            $top3 = [];
            $players = ['items' => [], 'total' => 0, 'page' => 1, 'per_page' => $perPage, 'offset' => 0, 'last_page' => 1];
            $errorMessage = $e->getMessage();
        }

        return response()->view('hnspts::pages.index', compact('summary', 'top3', 'players', 'query', 'sort', 'order', 'errorMessage'));
    }

    public function player(int $id)
    {
        try {
            $player = $this->ptsService->getPlayer($id);
        } catch (Throwable $e) {
            logs()->error('HNS PTS player page failed to load', ['exception' => $e, 'player_id' => $id]);
            return response()->error(500, $e->getMessage());
        }

        if (!$player) {
            return response()->error(404, __('hnspts.errors.player_not_found'));
        }

        return response()->view('hnspts::pages.player', compact('player'));
    }

    public function apiTop()
    {
        try {
            return json($this->ptsService->getTop(10));
        } catch (Throwable $e) {
            logs()->error('HNS PTS API top failed', ['exception' => $e]);
            return json(['error' => $e->getMessage()], 500);
        }
    }

    public function apiPlayer(int $id)
    {
        try {
            $player = $this->ptsService->getPlayer($id);
        } catch (Throwable $e) {
            logs()->error('HNS PTS API player failed', ['exception' => $e, 'player_id' => $id]);
            return json(['error' => $e->getMessage()], 500);
        }

        if (!$player) {
            return json(['error' => __('hnspts.errors.player_not_found')], 404);
        }

        return json($player);
    }
}
