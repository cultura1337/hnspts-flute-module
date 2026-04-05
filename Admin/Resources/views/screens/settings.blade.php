<div class="row gap-4">
    <div class="col-12 col-xl-8">
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="mb-3">{{ __('hnspts.admin.blocks.database') }}</h3>
                <form method="post" action="{{ route('admin.hnspts.test') }}" class="d-flex flex-column gap-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">DB Host</label>
                            <input type="text" class="form-control" name="db_host" value="{{ $settings['db']['host'] ?? '127.0.0.1' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">DB Port</label>
                            <input type="number" class="form-control" name="db_port" value="{{ $settings['db']['port'] ?? 3306 }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Charset</label>
                            <input type="text" class="form-control" name="db_charset" value="{{ $settings['db']['charset'] ?? 'utf8mb4' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Database</label>
                            <input type="text" class="form-control" name="db_database" value="{{ $settings['db']['database'] ?? 'hns' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="db_username" value="{{ $settings['db']['username'] ?? 'root' }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="db_password" value="{{ $settings['db']['password'] ?? '' }}">
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('hnspts.admin.fields.table_players') }}</label>
                            <input type="text" class="form-control" name="table_players" value="{{ $settings['tables']['players'] ?? 'cultura_players' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('hnspts.admin.fields.table_pts') }}</label>
                            <input type="text" class="form-control" name="table_pts" value="{{ $settings['tables']['pts'] ?? 'cultura_pts' }}">
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">{{ __('hnspts.admin.fields.column_player_pk') }}</label>
                            <input type="text" class="form-control" name="column_player_pk" value="{{ $settings['columns']['player_pk'] ?? 'id' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('hnspts.admin.fields.column_player_name') }}</label>
                            <input type="text" class="form-control" name="column_player_name" value="{{ $settings['columns']['player_name'] ?? 'player_name' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('hnspts.admin.fields.column_pts_player_fk') }}</label>
                            <input type="text" class="form-control" name="column_pts_player_fk" value="{{ $settings['columns']['pts_player_fk'] ?? 'player_id' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('hnspts.admin.fields.column_wins') }}</label>
                            <input type="text" class="form-control" name="column_wins" value="{{ $settings['columns']['wins'] ?? 'wins' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('hnspts.admin.fields.column_losses') }}</label>
                            <input type="text" class="form-control" name="column_losses" value="{{ $settings['columns']['losses'] ?? 'loss' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('hnspts.admin.fields.column_pts') }}</label>
                            <input type="text" class="form-control" name="column_pts" value="{{ $settings['columns']['pts'] ?? 'pts' }}">
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap align-items-center">
                        <button type="submit" class="btn btn-outline-primary">{{ __('hnspts.admin.buttons.test_connection') }}</button>
                        @if(!empty($testResult))
                            <span class="badge {{ !empty($testResult['ok']) ? 'bg-success' : 'bg-danger' }}">{{ $testResult['message'] ?? '' }}</span>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h3 class="mb-3">{{ __('hnspts.admin.blocks.module') }}</h3>
                <form method="post" action="{{ route('admin.hnspts.save') }}" class="d-flex flex-column gap-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">{{ __('hnspts.admin.fields.per_page') }}</label>
                            <input type="number" class="form-control" name="per_page" value="{{ $settings['per_page'] ?? 25 }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ __('hnspts.admin.fields.max_per_page') }}</label>
                            <input type="number" class="form-control" name="max_per_page" value="{{ $settings['max_per_page'] ?? 100 }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ __('hnspts.admin.fields.default_sort') }}</label>
                            <select class="form-select" name="default_sort">
                                @foreach(['pts', 'wins', 'losses', 'player_name'] as $sort)
                                    <option value="{{ $sort }}" @selected(($settings['default_sort'] ?? 'pts') === $sort)>{{ __('hnspts.sort_values.' . $sort) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">{{ __('hnspts.admin.fields.default_order') }}</label>
                            <select class="form-select" name="default_order">
                                @foreach(['desc', 'asc'] as $order)
                                    <option value="{{ $order }}" @selected(($settings['default_order'] ?? 'desc') === $order)>{{ __('hnspts.order_values.' . $order) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">{{ __('hnspts.admin.fields.widget_title') }}</label>
                            <input type="text" class="form-control" name="widget_title" value="{{ $settings['widget']['title'] ?? 'PTS Top' }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">{{ __('hnspts.admin.fields.widget_limit') }}</label>
                            <input type="number" class="form-control" name="widget_limit" value="{{ $settings['widget']['limit'] ?? 5 }}">
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="widget_show_wins" id="widget_show_wins" value="1" @checked(!empty($settings['widget']['show_wins']))>
                                <label class="form-check-label" for="widget_show_wins">{{ __('hnspts.admin.fields.widget_show_wins') }}</label>
                            </div>
                        </div>
                        <div class="col-md-3 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="widget_show_view_all" id="widget_show_view_all" value="1" @checked(!empty($settings['widget']['show_view_all']))>
                                <label class="form-check-label" for="widget_show_view_all">{{ __('hnspts.admin.fields.widget_show_view_all') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">DB Host</label>
                            <input type="text" class="form-control" name="db_host" value="{{ $settings['db']['host'] ?? '127.0.0.1' }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">DB Port</label>
                            <input type="number" class="form-control" name="db_port" value="{{ $settings['db']['port'] ?? 3306 }}">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Charset</label>
                            <input type="text" class="form-control" name="db_charset" value="{{ $settings['db']['charset'] ?? 'utf8mb4' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Database</label>
                            <input type="text" class="form-control" name="db_database" value="{{ $settings['db']['database'] ?? 'hns' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" name="db_username" value="{{ $settings['db']['username'] ?? 'root' }}">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="db_password" value="{{ $settings['db']['password'] ?? '' }}">
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">{{ __('hnspts.admin.fields.table_players') }}</label>
                            <input type="text" class="form-control" name="table_players" value="{{ $settings['tables']['players'] ?? 'cultura_players' }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">{{ __('hnspts.admin.fields.table_pts') }}</label>
                            <input type="text" class="form-control" name="table_pts" value="{{ $settings['tables']['pts'] ?? 'cultura_pts' }}">
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">{{ __('hnspts.admin.fields.column_player_pk') }}</label>
                            <input type="text" class="form-control" name="column_player_pk" value="{{ $settings['columns']['player_pk'] ?? 'id' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('hnspts.admin.fields.column_player_name') }}</label>
                            <input type="text" class="form-control" name="column_player_name" value="{{ $settings['columns']['player_name'] ?? 'player_name' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('hnspts.admin.fields.column_pts_player_fk') }}</label>
                            <input type="text" class="form-control" name="column_pts_player_fk" value="{{ $settings['columns']['pts_player_fk'] ?? 'player_id' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('hnspts.admin.fields.column_wins') }}</label>
                            <input type="text" class="form-control" name="column_wins" value="{{ $settings['columns']['wins'] ?? 'wins' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('hnspts.admin.fields.column_losses') }}</label>
                            <input type="text" class="form-control" name="column_losses" value="{{ $settings['columns']['losses'] ?? 'loss' }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">{{ __('hnspts.admin.fields.column_pts') }}</label>
                            <input type="text" class="form-control" name="column_pts" value="{{ $settings['columns']['pts'] ?? 'pts' }}">
                        </div>
                    </div>

                    <div class="d-flex gap-2 flex-wrap">
                        <button type="submit" class="btn btn-primary">{{ __('hnspts.admin.buttons.save') }}</button>
                        <a href="{{ route('hnspts.index') }}" class="btn btn-outline-secondary" target="_blank">{{ __('hnspts.admin.buttons.open_public') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-4">
        <div class="card">
            <div class="card-body d-flex flex-column gap-3">
                <h3 class="mb-0">{{ __('hnspts.admin.blocks.help') }}</h3>
                <p class="text-muted mb-0">{{ __('hnspts.admin.help_text') }}</p>
                <ul class="mb-0 ps-3 text-muted d-flex flex-column gap-2">
                    <li>{{ __('hnspts.admin.tips.override_file') }}</li>
                    <li>{{ __('hnspts.admin.tips.widget') }}</li>
                    <li>{{ __('hnspts.admin.tips.public_route') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>
