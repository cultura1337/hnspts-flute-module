@extends('flute::layouts.app')

@section('title', 'HNS PTS')
@section('description', 'HNS Mix player rating')

@push('styles')
<style>
    .pts-shell{
        width:100%;
        max-width:1440px;
        margin:0 auto;
        padding:18px 18px 36px;
    }
    .pts-hero{
        display:flex;
        flex-direction:column;
        align-items:center;
        text-align:center;
        gap:10px;
        margin-bottom:26px;
    }
    .pts-title{
        margin:0;
        font-size:54px;
        line-height:1;
        font-weight:900;
        letter-spacing:-0.03em;
    }
    .pts-subtitle{
        margin:0;
        max-width:900px;
        color:var(--text-muted, #98a2b3);
        font-size:18px;
    }
    .pts-cards{
        display:grid;
        grid-template-columns:repeat(4,minmax(0,1fr));
        gap:16px;
        margin-bottom:24px;
    }
    .pts-card,
    .pts-top-card,
    .pts-table-wrap,
    .pts-empty{
        background:var(--background-card, rgba(255,255,255,.02));
        border:1px solid rgba(255,255,255,.06);
        border-radius:20px;
        box-shadow:0 8px 24px rgba(0,0,0,.18);
    }
    .pts-card{
        padding:20px;
        text-align:center;
    }
    .pts-card-label{
        font-size:13px;
        color:var(--text-muted, #98a2b3);
        margin-bottom:10px;
        text-transform:uppercase;
        letter-spacing:.08em;
    }
    .pts-card-value{
        font-size:34px;
        font-weight:900;
        line-height:1.1;
    }
    .pts-top3{
        display:grid;
        grid-template-columns:repeat(3,minmax(0,1fr));
        gap:16px;
        margin-bottom:24px;
    }
    .pts-top-card{
        padding:22px;
        text-align:center;
    }
    .pts-badge{
        display:inline-flex;
        justify-content:center;
        align-items:center;
        padding:7px 14px;
        border-radius:999px;
        font-size:12px;
        font-weight:800;
        margin-bottom:14px;
        background:rgba(255,255,255,.06);
    }
    .pts-nick{
        font-size:24px;
        font-weight:900;
        margin:0 0 8px;
        word-break:break-word;
    }
    .pts-points{
        font-size:30px;
        font-weight:900;
        color:#9CFF57;
        margin-bottom:14px;
    }
    .pts-mini{
        display:grid;
        grid-template-columns:repeat(3,1fr);
        gap:12px;
        color:var(--text-muted, #98a2b3);
        font-size:14px;
    }
    .pts-mini strong{
        display:block;
        color:inherit;
        font-size:18px;
        margin-bottom:4px;
    }
    .pts-toolbar{
        display:flex;
        justify-content:center;
        align-items:center;
        gap:12px;
        flex-wrap:wrap;
        margin-bottom:18px;
    }
    .pts-search{
        display:flex;
        justify-content:center;
        gap:10px;
        flex-wrap:wrap;
        width:100%;
    }
    .pts-search input,
    .pts-search select{
        min-height:48px;
        padding:10px 14px;
        border-radius:14px;
        border:1px solid rgba(255,255,255,.08);
        background:rgba(255,255,255,.03);
        color:inherit;
        min-width:220px;
    }
    .pts-btn{
        min-height:48px;
        padding:10px 18px;
        border-radius:14px;
        border:1px solid rgba(255,255,255,.08);
        background:#9CFF57;
        color:#111;
        font-weight:900;
        text-decoration:none;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        cursor:pointer;
    }
    .pts-table-wrap{
        overflow:auto;
    }
    .pts-table{
        width:100%;
        border-collapse:collapse;
        min-width:980px;
    }
    .pts-table th,
    .pts-table td{
        padding:18px 18px;
        border-bottom:1px solid rgba(255,255,255,.06);
        text-align:left;
    }
    .pts-table th{
        font-size:13px;
        text-transform:uppercase;
        letter-spacing:.08em;
        color:var(--text-muted, #98a2b3);
        font-weight:800;
    }
    .pts-rank{
        font-weight:900;
        width:72px;
    }
    .pts-rank-1{color:#f3c969}
    .pts-rank-2{color:#bcc7d8}
    .pts-rank-3{color:#d39c73}
    .pts-name a{
        text-decoration:none;
        color:inherit;
        font-weight:800;
    }
    .pts-name a:hover{
        color:#9CFF57;
    }
    .pts-points-cell{
        color:#9CFF57;
        font-weight:900;
    }
    .pts-muted{
        color:var(--text-muted, #98a2b3);
    }
    .pts-pager{
        display:flex;
        gap:10px;
        justify-content:center;
        align-items:center;
        flex-wrap:wrap;
        margin-top:18px;
    }
    .pts-pager a,
    .pts-pager span{
        min-width:42px;
        height:42px;
        padding:0 14px;
        border-radius:12px;
        display:inline-flex;
        align-items:center;
        justify-content:center;
        border:1px solid rgba(255,255,255,.08);
        text-decoration:none;
        color:inherit;
        background:rgba(255,255,255,.03);
        font-weight:800;
    }
    .pts-pager .active{
        background:#9CFF57;
        color:#111;
        border-color:transparent;
    }
    .pts-empty{
        padding:36px 24px;
        text-align:center;
    }
    .pts-empty h3{
        margin:0 0 10px;
        font-size:24px;
    }
    .pts-empty p{
        margin:0;
        color:var(--text-muted, #98a2b3);
    }
    @media (max-width:1100px){
        .pts-cards,
        .pts-top3{
            grid-template-columns:1fr 1fr;
        }
    }
    @media (max-width:700px){
        .pts-shell{
            padding:14px 12px 28px;
        }
        .pts-title{
            font-size:38px;
        }
        .pts-subtitle{
            font-size:15px;
        }
        .pts-cards,
        .pts-top3{
            grid-template-columns:1fr;
        }
        .pts-search input,
        .pts-search select,
        .pts-btn{
            width:100%;
        }
    }
</style>
@endpush

@push('content')
@php
    $baseUrl = '/mix-pts';

    $makeUrl = function (int $page) use ($baseUrl, $query, $sort, $order) {
        $params = array_filter([
            'page' => $page > 1 ? $page : null,
            'q' => $query !== '' ? $query : null,
            'sort' => $sort !== 'pts' ? $sort : null,
            'order' => $order !== 'desc' ? $order : null,
        ], fn ($v) => $v !== null && $v !== '');

        return $baseUrl . (count($params) ? ('?' . http_build_query($params)) : '');
    };

    $makeSortUrl = function (string $newSort) use ($baseUrl, $query, $sort, $order) {
        $newOrder = ($sort === $newSort && $order === 'desc') ? 'asc' : 'desc';

        $params = array_filter([
            'q' => $query !== '' ? $query : null,
            'sort' => $newSort,
            'order' => $newOrder,
        ], fn ($v) => $v !== null && $v !== '');

        return $baseUrl . '?' . http_build_query($params);
    };
@endphp

<div class="pts-shell">
    <div class="pts-hero">
        <h1 class="pts-title">HNS PTS</h1>
        <p class="pts-subtitle">
            HNS Mix player rating with search, sorting, top players, and individual player pages.
        </p>
    </div>

    <div class="pts-cards">
        <div class="pts-card">
            <div class="pts-card-label">Total Players</div>
            <div class="pts-card-value">{{ number_format((int)($summary['total_players'] ?? 0), 0, '.', ' ') }}</div>
        </div>
        <div class="pts-card">
            <div class="pts-card-label">Average PTS</div>
            <div class="pts-card-value">{{ number_format((int)($summary['avg_pts'] ?? 0), 0, '.', ' ') }}</div>
        </div>
        <div class="pts-card">
            <div class="pts-card-label">Leader</div>
            <div class="pts-card-value" style="font-size:24px">{{ $summary['leader_name'] ?? '—' }}</div>
        </div>
        <div class="pts-card">
            <div class="pts-card-label">Max PTS</div>
            <div class="pts-card-value">{{ number_format((int)($summary['max_pts'] ?? 0), 0, '.', ' ') }}</div>
        </div>
    </div>

    @if (!empty($top3))
        <div class="pts-top3">
            @foreach ($top3 as $i => $item)
                <div class="pts-top-card">
                    <div class="pts-badge">{{ $i === 0 ? 'Top 1' : ($i === 1 ? 'Top 2' : 'Top 3') }}</div>
                    <div class="pts-nick">{{ $item['name'] }}</div>
                    <div class="pts-points">{{ number_format((int)$item['pts'], 0, '.', ' ') }} PTS</div>
                    <div class="pts-mini">
                        <div><strong>{{ (int)$item['wins'] }}</strong>Wins</div>
                        <div><strong>{{ (int)$item['losses'] }}</strong>Loss</div>
                        <div><strong>{{ number_format((float)$item['winrate'], 1) }}%</strong>WR</div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="pts-toolbar">
        <form class="pts-search" method="get" action="{{ $baseUrl }}">
            <input type="text" name="q" value="{{ $query }}" placeholder="Search by nickname or SteamID">
            <select name="sort">
                <option value="pts" {{ $sort === 'pts' ? 'selected' : '' }}>Sort: PTS</option>
                <option value="wins" {{ $sort === 'wins' ? 'selected' : '' }}>Sort: Wins</option>
                <option value="losses" {{ $sort === 'losses' ? 'selected' : '' }}>Sort: Loss</option>
                <option value="name" {{ $sort === 'name' ? 'selected' : '' }}>Sort: Name</option>
            </select>
            <select name="order">
                <option value="desc" {{ $order === 'desc' ? 'selected' : '' }}>Descending</option>
                <option value="asc" {{ $order === 'asc' ? 'selected' : '' }}>Ascending</option>
            </select>
            <button class="pts-btn" type="submit">Apply</button>
        </form>
    </div>

    <div class="pts-table-wrap">
        <table class="pts-table">
            <thead>
            <tr>
                <th>#</th>
                <th>Player</th>
                <th><a href="{{ $makeSortUrl('pts') }}" style="color:inherit;text-decoration:none;">PTS</a></th>
                <th><a href="{{ $makeSortUrl('wins') }}" style="color:inherit;text-decoration:none;">Wins</a></th>
                <th><a href="{{ $makeSortUrl('losses') }}" style="color:inherit;text-decoration:none;">Loss</a></th>
                <th>Winrate</th>
                <th>SteamID</th>
                <th>Profile</th>
            </tr>
            </thead>
            <tbody>
            @forelse(($players['items'] ?? []) as $item)
                @php
                    $rank = ($players['offset'] ?? 0) + $loop->iteration;
                    $rankClass = $rank === 1 ? 'pts-rank-1' : ($rank === 2 ? 'pts-rank-2' : ($rank === 3 ? 'pts-rank-3' : ''));
                @endphp
                <tr>
                    <td class="pts-rank {{ $rankClass }}">{{ $rank }}</td>
                    <td class="pts-name">
                        <a href="{{ $baseUrl . '/player/' . (int)$item['id'] }}">{{ $item['name'] }}</a>
                    </td>
                    <td class="pts-points-cell">{{ number_format((int)$item['pts'], 0, '.', ' ') }}</td>
                    <td>{{ (int)$item['wins'] }}</td>
                    <td>{{ (int)$item['losses'] }}</td>
                    <td>{{ number_format((float)$item['winrate'], 1) }}%</td>
                    <td class="pts-muted">{{ $item['steamid'] ?: '—' }}</td>
                    <td>
                        <a class="pts-btn" style="min-height:38px;padding:8px 12px" href="{{ $baseUrl . '/player/' . (int)$item['id'] }}">
                            View
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="padding:24px 18px;text-align:center" class="pts-muted">
                        No players found
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    @if (($players['last_page'] ?? 1) > 1)
        <div class="pts-pager">
            @if (($players['page'] ?? 1) > 1)
                <a href="{{ $makeUrl($players['page'] - 1) }}">←</a>
            @endif

            @for ($p = 1; $p <= $players['last_page']; $p++)
                @if ($p == $players['page'])
                    <span class="active">{{ $p }}</span>
                @elseif ($p >= max(1, $players['page'] - 2) && $p <= min($players['last_page'], $players['page'] + 2))
                    <a href="{{ $makeUrl($p) }}">{{ $p }}</a>
                @endif
            @endfor

            @if (($players['page'] ?? 1) < ($players['last_page'] ?? 1))
                <a href="{{ $makeUrl($players['page'] + 1) }}">→</a>
            @endif
        </div>
    @endif
</div>
@endpush
