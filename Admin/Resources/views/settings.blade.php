<style>
    .hnspts-admin {
        max-width: 1400px;
        margin: 0 auto;
    }

    .hnspts-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .hnspts-title {
        margin: 0 0 8px;
        font-size: 56px;
        line-height: 1;
        font-weight: 900;
        letter-spacing: -0.03em;
    }

    .hnspts-subtitle {
        margin: 0;
        color: #98a2b3;
        font-size: 18px;
    }

    .hnspts-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 46px;
        padding: 0 18px;
        border-radius: 14px;
        border: 1px solid rgba(255,255,255,.08);
        background: #23262f;
        color: #fff;
        text-decoration: none;
        font-weight: 800;
        cursor: pointer;
    }

    .hnspts-btn--green {
        background: #9CFF57;
        color: #111;
    }

    .hnspts-alert {
        margin-bottom: 18px;
        padding: 14px 16px;
        border-radius: 14px;
        font-weight: 700;
    }

    .hnspts-alert--ok {
        background: rgba(108, 255, 125, .10);
        border: 1px solid rgba(108, 255, 125, .20);
    }

    .hnspts-alert--err {
        background: rgba(255, 99, 99, .10);
        border: 1px solid rgba(255, 99, 99, .20);
    }

    .hnspts-grid {
        display: grid;
        grid-template-columns: 1.15fr .85fr;
        gap: 18px;
        margin-bottom: 18px;
    }

    .hnspts-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .hnspts-card {
        background: rgba(255,255,255,.02);
        border: 1px solid rgba(255,255,255,.06);
        border-radius: 22px;
        padding: 22px;
        box-shadow: 0 8px 24px rgba(0,0,0,.18);
    }

    .hnspts-card-title {
        margin: 0 0 18px;
        font-size: 28px;
        font-weight: 900;
        line-height: 1.1;
    }

    .hnspts-form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px 18px;
    }

    .hnspts-field label {
        display: block;
        margin-bottom: 8px;
        color: #98a2b3;
        font-size: 13px;
    }

    .hnspts-input,
    .hnspts-select {
        width: 100%;
        height: 46px;
        padding: 0 14px;
        border-radius: 14px;
        border: 1px solid rgba(255,255,255,.08);
        background: rgba(255,255,255,.04);
        color: #fff;
        outline: none;
    }

    .hnspts-checkboxes {
        display: flex;
        gap: 22px;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .hnspts-checkboxes label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #d7dde7;
    }

    .hnspts-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 18px;
    }

    .hnspts-notes {
        margin: 0;
        padding-left: 18px;
        color: #a7b2c2;
        line-height: 1.7;
    }

    .hnspts-notes code {
        color: #fff;
        background: rgba(255,255,255,.05);
        padding: 2px 6px;
        border-radius: 6px;
    }

    @media (max-width: 1100px) {
        .hnspts-grid,
        .hnspts-grid-2,
        .hnspts-form-grid {
            grid-template-columns: 1fr;
        }

        .hnspts-title {
            font-size: 42px;
        }
    }
</style>

<div class="hnspts-admin">
    <div class="hnspts-head">
        <div>
            <h1 class="hnspts-title">HNS PTS</h1>
            <p class="hnspts-subtitle">Настройки модуля HNS PTS</p>
        </div>

        <a href="{{ $publicUrl ?? '/mix-pts' }}" class="hnspts-btn">
            Открыть публичную страницу
        </a>
    </div>

    @if (session('success'))
        <div class="hnspts-alert hnspts-alert--ok">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="hnspts-alert hnspts-alert--err">
            {{ session('error') }}
        </div>
    @endif

    <div class="hnspts-grid">
        <form method="post" action="/admin/hns-pts/test" class="hnspts-card">
            @csrf
            <h2 class="hnspts-card-title">Подключение к базе данных</h2>

            <div class="hnspts-form-grid">
                <div class="hnspts-field">
                    <label>Host</label>
                    <input class="hnspts-input" type="text" name="db_host" value="{{ $settings['db']['host'] ?? '127.0.0.1' }}">
                </div>

                <div class="hnspts-field">
                    <label>Port</label>
                    <input class="hnspts-input" type="text" name="db_port" value="{{ $settings['db']['port'] ?? 3306 }}">
                </div>

                <div class="hnspts-field">
                    <label>Database</label>
                    <input class="hnspts-input" type="text" name="db_database" value="{{ $settings['db']['database'] ?? '' }}">
                </div>

                <div class="hnspts-field">
                    <label>Username</label>
                    <input class="hnspts-input" type="text" name="db_username" value="{{ $settings['db']['username'] ?? '' }}">
                </div>

                <div class="hnspts-field">
                    <label>Password</label>
                    <input class="hnspts-input" type="password" name="db_password" value="{{ $settings['db']['password'] ?? '' }}">
                </div>

                <div class="hnspts-field">
                    <label>Charset</label>
                    <input class="hnspts-input" type="text" name="db_charset" value="{{ $settings['db']['charset'] ?? 'utf8mb4' }}">
                </div>
            </div>

            <div class="hnspts-actions">
                <button type="submit" class="hnspts-btn">Проверить подключение</button>
            </div>
        </form>

        <div class="hnspts-card">
            <h2 class="hnspts-card-title">Подсказки</h2>
            <ul class="hnspts-notes">
                <li>Настройки сохраняются в <code>storage/app/modules/hnspts/settings.json</code></li>
                <li>Публичный маршрут берётся из <code>route_prefix</code> в конфиге</li>
                <li>Виджет top players использует те же настройки БД</li>
            </ul>
        </div>
    </div>

    <form method="post" action="/admin/hns-pts/save" class="hnspts-card">
        @csrf
        <h2 class="hnspts-card-title">Схема таблиц и параметры модуля</h2>

        <div class="hnspts-grid-2">
            <div class="hnspts-form-grid">
                <div class="hnspts-field">
                    <label>Таблица игроков</label>
                    <input class="hnspts-input" type="text" name="table_players" value="{{ $settings['tables']['players'] ?? 'hns_players' }}">
                </div>

                <div class="hnspts-field">
                    <label>Таблица PTS</label>
                    <input class="hnspts-input" type="text" name="table_pts" value="{{ $settings['tables']['pts'] ?? 'hns_pts' }}">
                </div>

                <div class="hnspts-field">
                    <label>PK игрока</label>
                    <input class="hnspts-input" type="text" name="column_player_pk" value="{{ $settings['columns']['player_pk'] ?? 'id' }}">
                </div>

                <div class="hnspts-field">
                    <label>Колонка ника</label>
                    <input class="hnspts-input" type="text" name="column_player_name" value="{{ $settings['columns']['player_name'] ?? 'name' }}">
                </div>

                <div class="hnspts-field">
                    <label>FK в таблице PTS</label>
                    <input class="hnspts-input" type="text" name="column_pts_player_fk" value="{{ $settings['columns']['pts_player_fk'] ?? 'id' }}">
                </div>

                <div class="hnspts-field">
                    <label>Колонка побед</label>
                    <input class="hnspts-input" type="text" name="column_wins" value="{{ $settings['columns']['wins'] ?? 'wins' }}">
                </div>

                <div class="hnspts-field">
                    <label>Колонка поражений</label>
                    <input class="hnspts-input" type="text" name="column_losses" value="{{ $settings['columns']['losses'] ?? 'loss' }}">
                </div>

                <div class="hnspts-field">
                    <label>Колонка PTS</label>
                    <input class="hnspts-input" type="text" name="column_pts" value="{{ $settings['columns']['pts'] ?? 'pts' }}">
                </div>

                <div class="hnspts-field">
                    <label>Колонка SteamID</label>
                    <input class="hnspts-input" type="text" name="column_steamid" value="{{ $settings['columns']['steamid'] ?? 'steamid' }}">
                </div>

                <div class="hnspts-field">
                    <label>Колонка IP</label>
                    <input class="hnspts-input" type="text" name="column_ip" value="{{ $settings['columns']['ip'] ?? 'ip' }}">
                </div>

                <div class="hnspts-field">
                    <label>Колонка времени в игре</label>
                    <input class="hnspts-input" type="text" name="column_playtime" value="{{ $settings['columns']['playtime'] ?? 'playtime' }}">
                </div>

                <div class="hnspts-field">
                    <label>Колонка последнего входа</label>
                    <input class="hnspts-input" type="text" name="column_lastconnect" value="{{ $settings['columns']['lastconnect'] ?? 'lastconnect' }}">
                </div>
            </div>

            <div class="hnspts-form-grid">
                <div class="hnspts-field">
                    <label>Игроков на страницу</label>
                    <input class="hnspts-input" type="number" name="per_page" value="{{ $settings['per_page'] ?? 25 }}">
                </div>

                <div class="hnspts-field">
                    <label>Максимум на страницу</label>
                    <input class="hnspts-input" type="number" name="max_per_page" value="{{ $settings['max_per_page'] ?? 100 }}">
                </div>

                <div class="hnspts-field">
                    <label>Сортировка по умолчанию</label>
                    <select class="hnspts-select" name="default_sort">
                        <option value="pts" @selected(($settings['default_sort'] ?? 'pts') === 'pts')>PTS</option>
                        <option value="wins" @selected(($settings['default_sort'] ?? '') === 'wins')>Wins</option>
                        <option value="losses" @selected(($settings['default_sort'] ?? '') === 'losses')>Losses</option>
                        <option value="name" @selected(($settings['default_sort'] ?? '') === 'name')>Name</option>
                    </select>
                </div>

                <div class="hnspts-field">
                    <label>Порядок по умолчанию</label>
                    <select class="hnspts-select" name="default_order">
                        <option value="desc" @selected(($settings['default_order'] ?? 'desc') === 'desc')>По убыванию</option>
                        <option value="asc" @selected(($settings['default_order'] ?? '') === 'asc')>По возрастанию</option>
                    </select>
                </div>

                <div class="hnspts-field">
                    <label>Заголовок виджета</label>
                    <input class="hnspts-input" type="text" name="widget_title" value="{{ $settings['widget']['title'] ?? 'PTS Top' }}">
                </div>

                <div class="hnspts-field">
                    <label>Количество игроков</label>
                    <input class="hnspts-input" type="number" name="widget_limit" value="{{ $settings['widget']['limit'] ?? 5 }}">
                </div>
            </div>
        </div>

        <div class="hnspts-checkboxes">
            <label>
                <input type="checkbox" name="widget_show_wins" value="1" @checked(!empty($settings['widget']['show_wins']))>
                Показывать победы
            </label>

            <label>
                <input type="checkbox" name="widget_show_view_all" value="1" @checked(!empty($settings['widget']['show_view_all']))>
                Показывать кнопку "Смотреть все"
            </label>
        </div>

        <div class="hnspts-actions">
            <button type="submit" class="hnspts-btn hnspts-btn--green">Сохранить</button>
        </div>
    </form>
</div>
