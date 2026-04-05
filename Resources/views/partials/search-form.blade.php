<div class="hnspts-card" style="margin-bottom:1rem;">
    <form method="GET" action="{{ route('hnspts.index') }}" class="hnspts-search">
        <div class="field">
            <label for="hnspts-search">{{ __('hnspts.search') }}</label>
            <input
                id="hnspts-search"
                type="text"
                name="search"
                value="{{ $filters['search'] ?? '' }}"
                placeholder="{{ __('hnspts.search_placeholder') }}"
            >
        </div>

        <div class="field">
            <label for="hnspts-sort">{{ __('hnspts.sort') }}</label>
            <select id="hnspts-sort" name="sort">
                @foreach(['pts', 'wins', 'losses', 'player_name'] as $value)
                    <option value="{{ $value }}" @selected(($filters['sort'] ?? 'pts') === $value)>
                        {{ __('hnspts.sort_values.' . $value) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="hnspts-order">{{ __('hnspts.order') }}</label>
            <select id="hnspts-order" name="order">
                @foreach(['desc', 'asc'] as $value)
                    <option value="{{ $value }}" @selected(($filters['order'] ?? 'desc') === $value)>
                        {{ __('hnspts.order_values.' . $value) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="hnspts-per-page">{{ __('hnspts.per_page') }}</label>
            <select id="hnspts-per-page" name="per_page">
                @foreach($allowedPerPage as $value)
                    <option value="{{ $value }}" @selected((int) $perPage === (int) $value)>{{ $value }}</option>
                @endforeach
            </select>
        </div>

        <div class="hnspts-actions">
            <button type="submit" class="hnspts-button">{{ __('hnspts.apply') }}</button>
            <a href="{{ route('hnspts.index') }}" class="hnspts-button">{{ __('hnspts.reset') }}</a>
        </div>
    </form>
</div>
