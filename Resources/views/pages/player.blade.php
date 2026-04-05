@extends('flute::layouts.app')

@section('title', ($player['name'] ?? 'Player') . ' — HNS PTS')

@push('styles')
<style>
    .pts-player-shell{
        width:100%;
        max-width:1100px;
        margin:0 auto;
        padding:18px 18px 36px;
    }
    .pts-player-back{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        min-height:44px;
        padding:10px 16px;
        border-radius:14px;
        text-decoration:none;
        font-weight:900;
        background:#9CFF57;
        color:#111;
        margin-bottom:18px;
        border:1px solid rgba(255,255,255,.08);
    }
    .pts-player-head,
    .pts-player-card,
    .pts-player-stat{
        background:var(--background-card, rgba(255,255,255,.02));
        border:1px solid rgba(255,255,255,.06);
        border-radius:20px;
        box-shadow:0 8px 24px rgba(0,0,0,.18);
    }
    .pts-player-head{
        padding:24px;
        margin-bottom:18px;
        display:flex;
        justify-content:space-between;
        align-items:flex-start;
        gap:18px;
        flex-wrap:wrap;
    }
    .pts-player-head-main{
        text-align:left;
    }
    .pts-player-title{
        margin:0 0 10px;
        font-size:42px;
        line-height:1.05;
        font-weight:900;
        word-break:break-word;
    }
    .pts-player-subtitle{
        margin:0;
        color:var(--text-muted, #98a2b3);
        font-size:17px;
    }
    .pts-player-badge{
        display:inline-flex;
        align-items:center;
        justify-content:center;
        min-height:46px;
        padding:10px 18px;
        border-radius:999px;
        background:rgba(156,255,87,.12);
        color:#9CFF57;
        font-weight:900;
        white-space:nowrap;
    }
    .pts-player-grid{
        display:grid;
        grid-template-columns:repeat(4,minmax(0,1fr));
        gap:16px;
        margin-bottom:18px;
    }
    .pts-player-stat{
        padding:20px;
        text-align:center;
    }
    .pts-player-label{
        font-size:13px;
        color:var(--text-muted, #98a2b3);
        margin-bottom:8px;
        text-transform:uppercase;
        letter-spacing:.08em;
    }
    .pts-player-value{
        font-size:32px;
        font-weight:900;
        line-height:1.1;
        word-break:break-word;
    }
    .pts-player-value--accent,
    .pts-player-value--good{
        color:#9CFF57;
    }
    .pts-player-value--bad{
        color:#ff7b7b;
    }
    .pts-player-card{
        padding:24px;
    }
    .pts-player-card-title{
        margin:0 0 16px;
        font-size:24px;
        font-weight:900;
        text-align:center;
    }
    .pts-player-list{
        display:grid;
        grid-template-columns:1fr 1fr;
        gap:16px 18px;
    }
    .pts-player-item{
        padding:14px 16px;
        border-radius:14px;
        background:rgba(255,255,255,.02);
        border:1px solid rgba(255,255,255,.05);
    }
    .pts-player-item-label{
        font-size:13px;
        color:var(--text-muted, #98a2b3);
        margin-bottom:6px;
        text-transform:uppercase;
        letter-spacing:.08em;
    }
    .pts-player-item-value{
        font-size:16px;
        font-weight:700;
        word-break:break-word;
    }
    @media (max-width:1100px){
        .pts-player-grid{
            grid-template-columns:repeat(2,minmax(0,1fr));
        }
    }
    @media (max-width:700px){
        .pts-player-shell{
            padding:14px 12px 28px;
        }
        .pts-player-grid,
        .pts-player-list{
            grid-template-columns:1fr;
        }
        .pts-player-title{
            font-size:34px;
        }
        .pts-player-head{
            text-align:center;
            justify-content:center;
        }
        .pts-player-head-main{
            text-align:center;
        }
    }
</style>
@endpush

@push('content')
@php
    $baseUrl = '/mix-pts';
    $lastConnect = !empty($player['lastconnect']) ? date('d.m.Y H:i', (int)$player['lastconnect']) : '—';
@endphp

<div class="pts-player-shell">
    <a href="{{ $baseUrl }}" class="pts-player-back">← Back to rating</a>

    <div class="pts-player-head">
        <div class="pts-player-head-main">
            <h1 class="pts-player-title">{{ $player['name'] ?? 'Unknown Player' }}</h1>
            <p class="pts-player-subtitle">Player profile and HNS PTS statistics.</p>
        </div>

        <div class="pts-player-badge">
            {{ number_format((int)($player['pts'] ?? 0), 0, '.', ' ') }} PTS
        </div>
    </div>

    <div class="pts-player-grid">
        <div class="pts-player-stat">
            <div class="pts-player-label">PTS</div>
            <div class="pts-player-value pts-player-value--accent">{{ number_format((int)($player['pts'] ?? 0), 0, '.', ' ') }}</div>
        </div>
        <div class="pts-player-stat">
            <div class="pts-player-label">Wins</div>
            <div class="pts-player-value">{{ (int)($player['wins'] ?? 0) }}</div>
        </div>
        <div class="pts-player-stat">
            <div class="pts-player-label">Loss</div>
            <div class="pts-player-value">{{ (int)($player['losses'] ?? 0) }}</div>
        </div>
        <div class="pts-player-stat">
            <div class="pts-player-label">Winrate</div>
            <div class="pts-player-value {{ (float)($player['winrate'] ?? 0) >= 50 ? 'pts-player-value--good' : 'pts-player-value--bad' }}">
                {{ number_format((float)($player['winrate'] ?? 0), 1) }}%
            </div>
        </div>
    </div>

    <div class="pts-player-card">
        <h2 class="pts-player-card-title">Player Information</h2>

        <div class="pts-player-list">
            <div class="pts-player-item">
                <div class="pts-player-item-label">ID</div>
                <div class="pts-player-item-value">{{ (int)($player['id'] ?? 0) }}</div>
            </div>

            <div class="pts-player-item">
                <div class="pts-player-item-label">Nickname</div>
                <div class="pts-player-item-value">{{ $player['name'] ?? '—' }}</div>
            </div>

            <div class="pts-player-item">
                <div class="pts-player-item-label">SteamID</div>
                <div class="pts-player-item-value">{{ $player['steamid'] ?: '—' }}</div>
            </div>

            <div class="pts-player-item">
                <div class="pts-player-item-label">IP</div>
                <div class="pts-player-item-value">{{ $player['ip'] ?: '—' }}</div>
            </div>

            <div class="pts-player-item">
                <div class="pts-player-item-label">Playtime</div>
                <div class="pts-player-item-value">{{ (int)($player['playtime'] ?? 0) }}</div>
            </div>

            <div class="pts-player-item">
                <div class="pts-player-item-label">Last Connect</div>
                <div class="pts-player-item-value">{{ $lastConnect }}</div>
            </div>
        </div>
    </div>
</div>
@endpush
