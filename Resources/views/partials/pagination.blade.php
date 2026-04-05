@if(($pagination['last_page'] ?? 1) > 1)
    <nav class="hnspts-pagination" aria-label="Pagination">
        @if(!empty($pagination['previous']))
            <a class="hnspts-pill" href="{{ $pagination['first'] }}">{{ __('hnspts.pagination.first') }}</a>
            <a class="hnspts-pill" href="{{ $pagination['previous'] }}">{{ __('hnspts.pagination.previous') }}</a>
        @endif

        @foreach($pagination['pages'] as $page)
            <a
                class="hnspts-pill {{ $page['active'] ? 'is-active' : '' }}"
                href="{{ $page['url'] }}"
            >
                {{ $page['page'] }}
            </a>
        @endforeach

        @if(!empty($pagination['next']))
            <a class="hnspts-pill" href="{{ $pagination['next'] }}">{{ __('hnspts.pagination.next') }}</a>
            <a class="hnspts-pill" href="{{ $pagination['last'] }}">{{ __('hnspts.pagination.last') }}</a>
        @endif
    </nav>
@endif
