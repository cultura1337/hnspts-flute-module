@extends('flute::layouts.app')

@section('title', __('hnspts.title'))

@push('styles')
<style>
    .hnspts-grid {
        display: grid;
        gap: 1rem;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        margin-bottom: 1rem;
    }

    .hnspts-card,
    .hnspts-summary {
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 14px;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.02);
    }

    .hnspts-summary__value {
        font-size: 1.5rem;
        font-weight: 700;
        margin-top: .25rem;
    }

    .hnspts-table-wrapper {
        overflow-x: auto;
    }

    .hnspts-table {
        width: 100%;
        border-collapse: collapse;
    }

    .hnspts-table th,
    .hnspts-table td {
        padding: .85rem .75rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        text-align: left;
        white-space: nowrap;
    }

    .hnspts-table th:last-child,
    .hnspts-table td:last-child,
    .hnspts-table td.num,
    .hnspts-table th.num {
        text-align: right;
    }

    .hnspts-actions,
    .hnspts-search {
        display: flex;
        gap: .75rem;
        flex-wrap: wrap;
        align-items: end;
    }

    .hnspts-search .field {
        display: flex;
        flex-direction: column;
        gap: .35rem;
        min-width: 170px;
        flex: 1 1 170px;
    }

    .hnspts-search input,
    .hnspts-search select {
        width: 100%;
        padding: .75rem .85rem;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        background: rgba(255, 255, 255, 0.03);
        color: inherit;
    }

    .hnspts-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 42px;
        padding: .7rem 1rem;
        border-radius: 10px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        text-decoration: none;
        color: inherit;
        background: rgba(255, 255, 255, 0.04);
    }

    .hnspts-pagination {
        display: flex;
        gap: .5rem;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 1rem;
    }

    .hnspts-pill {
        padding: .5rem .8rem;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        text-decoration: none;
        color: inherit;
    }

    .hnspts-pill.is-active {
        font-weight: 700;
        background: rgba(255, 255, 255, 0.08);
    }

    .hnspts-player-meta {
        display: grid;
        gap: 1rem;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    }

    .hnspts-muted {
        opacity: .75;
    }
</style>
@endpush

@section('content')
    <div class="container">
        @yield('hnspts-content')
    </div>
@endsection
