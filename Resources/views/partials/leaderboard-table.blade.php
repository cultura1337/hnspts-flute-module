<div class="hnspts-table-wrapper">
    <table class="hnspts-table">
        <thead>
            <tr>
                <th class="num">{{ __('hnspts.table.rank') }}</th>
                <th>{{ __('hnspts.table.player') }}</th>
                <th class="num">{{ __('hnspts.table.wins') }}</th>
                <th class="num">{{ __('hnspts.table.losses') }}</th>
                <th class="num">{{ __('hnspts.table.matches') }}</th>
                <th class="num">{{ __('hnspts.table.pts') }}</th>
                <th class="num">{{ __('hnspts.table.winrate') }}</th>
                <th class="num">{{ __('hnspts.table.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td class="num">#{{ $item['rank'] }}</td>
                    <td>
                        <a href="{{ route('hnspts.player', ['id' => $item['player_id']]) }}">
                            {{ $item['player_name'] ?: 'Unknown' }}
                        </a>
                    </td>
                    <td class="num">{{ $item['wins'] }}</td>
                    <td class="num">{{ $item['losses'] }}</td>
                    <td class="num">{{ $item['matches'] }}</td>
                    <td class="num"><strong>{{ $item['pts'] }}</strong></td>
                    <td class="num">{{ $item['winrate'] }}%</td>
                    <td class="num">
                        <a href="{{ route('hnspts.player', ['id' => $item['player_id']]) }}" class="hnspts-button">
                            {{ __('hnspts.buttons.view') }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
