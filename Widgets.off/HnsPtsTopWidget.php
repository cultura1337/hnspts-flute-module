<?php

declare(strict_types=1);

namespace Flute\Modules\HnsPts\Widgets;

use Flute\Modules\HnsPts\Services\PtsService;

if (interface_exists(\Flute\Core\Modules\Page\Widgets\Contracts\WidgetInterface::class)) {
    class HnsPtsTopWidget implements \Flute\Core\Modules\Page\Widgets\Contracts\WidgetInterface
    {
        public function getName(): string
        {
            return __('hnspts.widget.name');
        }

        public function getDescription(): string
        {
            return __('hnspts.widget.description');
        }

        public function getIcon(): string
        {
            return '<x-icon path="chart-bar" />';
        }

        public function getSettings(): array
        {
            return [
                'title' => [
                    'type' => 'text',
                    'label' => __('hnspts.admin.fields.widget_title'),
                    'default' => (string) config('hnspts.widget.title', 'PTS Top'),
                ],
                'limit' => [
                    'type' => 'number',
                    'label' => __('hnspts.admin.fields.widget_limit'),
                    'default' => (int) config('hnspts.widget.limit', 5),
                    'min' => 1,
                    'max' => 20,
                ],
                'show_wins' => [
                    'type' => 'boolean',
                    'label' => __('hnspts.admin.fields.widget_show_wins'),
                    'default' => (bool) config('hnspts.widget.show_wins', true),
                ],
                'show_view_all' => [
                    'type' => 'boolean',
                    'label' => __('hnspts.admin.fields.widget_show_view_all'),
                    'default' => (bool) config('hnspts.widget.show_view_all', true),
                ],
            ];
        }

        public function render(array $settings): ?string
        {
            /** @var PtsService $service */
            $service = app(PtsService::class);
            $prepared = $this->prepareSettings($settings);
            $items = $service->getApiTop($prepared['limit']);

            return view('hnspts::widgets.top', [
                'title' => $prepared['title'] !== '' ? $prepared['title'] : __('hnspts.widget.name'),
                'items' => $items,
                'showWins' => $prepared['show_wins'],
                'showViewAll' => $prepared['show_view_all'],
            ])->render();
        }

        public function renderSettingsForm(array $settings): string|bool
        {
            return false;
        }

        public function validateSettings(array $input): true|array
        {
            $errors = [];
            $limit = isset($input['limit']) ? (int) $input['limit'] : (int) config('hnspts.widget.limit', 5);

            if ($limit < 1 || $limit > 20) {
                $errors['limit'] = 'Limit must be between 1 and 20.';
            }

            if (isset($input['title']) && !is_scalar($input['title'])) {
                $errors['title'] = 'Title must be a string.';
            }

            return empty($errors) ? true : $errors;
        }

        public function saveSettings(array $input): array
        {
            return $this->prepareSettings($input);
        }

        public function hasSettings(): bool
        {
            return true;
        }

        public function getDefaultWidth(): int
        {
            return 6;
        }

        public function getMinWidth(): int
        {
            return 4;
        }

        public function getButtons(): array
        {
            return [];
        }

        public function handleAction(string $action, ?string $widgetId = null): array
        {
            return [
                'success' => false,
                'message' => 'Action not supported',
            ];
        }

        public function getCategory(): string
        {
            return 'hnspts';
        }

        protected function prepareSettings(array $settings): array
        {
            $title = trim((string) ($settings['title'] ?? config('hnspts.widget.title', 'PTS Top')));
            $limit = (int) ($settings['limit'] ?? config('hnspts.widget.limit', 5));
            $limit = max(1, min($limit, 20));

            $showWins = array_key_exists('show_wins', $settings)
                ? $this->toBool($settings['show_wins'])
                : (bool) config('hnspts.widget.show_wins', true);

            $showViewAll = array_key_exists('show_view_all', $settings)
                ? $this->toBool($settings['show_view_all'])
                : (bool) config('hnspts.widget.show_view_all', true);

            return [
                'title' => $title,
                'limit' => $limit,
                'show_wins' => $showWins,
                'show_view_all' => $showViewAll,
            ];
        }

        protected function toBool(mixed $value): bool
        {
            if (is_bool($value)) {
                return $value;
            }

            if (is_int($value)) {
                return $value === 1;
            }

            if (is_string($value)) {
                return in_array(strtolower($value), ['1', 'true', 'on', 'yes'], true);
            }

            return !empty($value);
        }
    }
} elseif (interface_exists(\Flute\Core\Widgets\WidgetInterface::class)) {
    class HnsPtsTopWidget implements \Flute\Core\Widgets\WidgetInterface
    {
        public function getName(): string
        {
            return __('hnspts.widget.name');
        }

        public function getDescription(): string
        {
            return __('hnspts.widget.description');
        }

        public function getIcon(): string
        {
            return '<x-icon path="chart-bar" />';
        }

        public function getSettings(): array
        {
            return [
                'title' => [
                    'type' => 'text',
                    'label' => __('hnspts.admin.fields.widget_title'),
                    'default' => (string) config('hnspts.widget.title', 'PTS Top'),
                ],
                'limit' => [
                    'type' => 'number',
                    'label' => __('hnspts.admin.fields.widget_limit'),
                    'default' => (int) config('hnspts.widget.limit', 5),
                    'min' => 1,
                    'max' => 20,
                ],
                'show_wins' => [
                    'type' => 'boolean',
                    'label' => __('hnspts.admin.fields.widget_show_wins'),
                    'default' => (bool) config('hnspts.widget.show_wins', true),
                ],
                'show_view_all' => [
                    'type' => 'boolean',
                    'label' => __('hnspts.admin.fields.widget_show_view_all'),
                    'default' => (bool) config('hnspts.widget.show_view_all', true),
                ],
            ];
        }

        public function render(array $settings): ?string
        {
            /** @var PtsService $service */
            $service = app(PtsService::class);
            $prepared = $this->prepareSettings($settings);
            $items = $service->getApiTop($prepared['limit']);

            return view('hnspts::widgets.top', [
                'title' => $prepared['title'] !== '' ? $prepared['title'] : __('hnspts.widget.name'),
                'items' => $items,
                'showWins' => $prepared['show_wins'],
                'showViewAll' => $prepared['show_view_all'],
            ])->render();
        }

        public function renderSettingsForm(array $settings): string|bool
        {
            return false;
        }

        public function validateSettings(array $input): true|array
        {
            $errors = [];
            $limit = isset($input['limit']) ? (int) $input['limit'] : (int) config('hnspts.widget.limit', 5);

            if ($limit < 1 || $limit > 20) {
                $errors['limit'] = 'Limit must be between 1 and 20.';
            }

            if (isset($input['title']) && !is_scalar($input['title'])) {
                $errors['title'] = 'Title must be a string.';
            }

            return empty($errors) ? true : $errors;
        }

        public function saveSettings(array $input): array
        {
            return $this->prepareSettings($input);
        }

        public function hasSettings(): bool
        {
            return true;
        }

        public function getDefaultWidth(): int
        {
            return 6;
        }

        public function getMinWidth(): int
        {
            return 4;
        }

        public function getButtons(): array
        {
            return [];
        }

        public function handleAction(string $action, ?string $widgetId = null): array
        {
            return [
                'success' => false,
                'message' => 'Action not supported',
            ];
        }

        public function getCategory(): string
        {
            return 'hnspts';
        }

        protected function prepareSettings(array $settings): array
        {
            $title = trim((string) ($settings['title'] ?? config('hnspts.widget.title', 'PTS Top')));
            $limit = (int) ($settings['limit'] ?? config('hnspts.widget.limit', 5));
            $limit = max(1, min($limit, 20));

            $showWins = array_key_exists('show_wins', $settings)
                ? $this->toBool($settings['show_wins'])
                : (bool) config('hnspts.widget.show_wins', true);

            $showViewAll = array_key_exists('show_view_all', $settings)
                ? $this->toBool($settings['show_view_all'])
                : (bool) config('hnspts.widget.show_view_all', true);

            return [
                'title' => $title,
                'limit' => $limit,
                'show_wins' => $showWins,
                'show_view_all' => $showViewAll,
            ];
        }

        protected function toBool(mixed $value): bool
        {
            if (is_bool($value)) {
                return $value;
            }

            if (is_int($value)) {
                return $value === 1;
            }

            if (is_string($value)) {
                return in_array(strtolower($value), ['1', 'true', 'on', 'yes'], true);
            }

            return !empty($value);
        }
    }
} else {
    class HnsPtsTopWidget
    {
        public function getName(): string
        {
            return __('hnspts.widget.name');
        }

        public function getDescription(): string
        {
            return __('hnspts.widget.description');
        }

        public function getIcon(): string
        {
            return '<x-icon path="chart-bar" />';
        }

        public function getSettings(): array
        {
            return [];
        }

        public function render(array $settings = []): string
        {
            /** @var PtsService $service */
            $service = app(PtsService::class);
            $items = $service->getApiTop(max(1, min((int) ($settings['limit'] ?? 5), 20)));

            return view('hnspts::widgets.top', [
                'title' => __('hnspts.widget.name'),
                'items' => $items,
                'showWins' => true,
                'showViewAll' => true,
            ])->render();
        }
    }
}
