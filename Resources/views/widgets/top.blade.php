<div style="padding:18px;border-radius:18px;background:var(--background-card,rgba(255,255,255,.02));border:1px solid rgba(255,255,255,.06);box-shadow:0 8px 24px rgba(0,0,0,.18);">
    <div style="font-size:20px;font-weight:900;margin-bottom:14px;">{{ $title }}</div>

    @forelse($items as $item)
        <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;padding:10px 0;border-top:1px solid rgba(255,255,255,.06);{{ $loop->first ? 'border-top:0;padding-top:0;' : '' }}">
            <div>
                <div style="font-weight:800;">{{ $item['name'] }}</div>
                @if($showWins)
                    <div style="font-size:13px;color:var(--text-muted,#98a2b3);">{{ (int) $item['wins'] }} / {{ (int) $item['losses'] }}</div>
                @endif
            </div>
            <div style="font-weight:900;color:#9CFF57;white-space:nowrap;">{{ number_format((int) $item['pts'], 0, '.', ' ') }} PTS</div>
        </div>
    @empty
        <div style="color:var(--text-muted,#98a2b3);">{{ __('hnspts.empty.title') }}</div>
    @endforelse

    @if($showViewAll)
        <div style="margin-top:14px;">
            <a href="{{ route('hnspts.index') }}" style="display:inline-flex;align-items:center;justify-content:center;min-height:40px;padding:8px 14px;border-radius:12px;background:#9CFF57;color:#111;font-weight:900;text-decoration:none;">
                {{ __('hnspts.widget.view_all') }}
            </a>
        </div>
    @endif
</div>
