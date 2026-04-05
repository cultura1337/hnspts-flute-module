<?php

declare(strict_types=1);

namespace Flute\Modules\HnsPts\Widgets;

use Flute\Modules\HnsPts\Services\PtsService;

if (interface_exists(\Flute\Core\Modules\Page\Widgets\Contracts\WidgetInterface::class)) {
    class HnsPtsTopWidget implements \Flute\Core\Modules\Page\Widgets\Contracts\WidgetInterface
    {
        public function getName(): string { return __('hnspts.widget.name'); }
        public function getDescription(): string { return __('hnspts.widget.description'); }
        public function getIcon(): string { return '<x-icon path="ph.bold.chart-line-up-bold" />'; }
        public function getSettings(): array { return $this->settingsDefinition(); }
        public function render(array $settings): ?string { return $this->renderWidget($settings); }
        public function renderSettingsForm(array $settings): string|bool { return false; }
        public function validateSettings(array $input): true|array { return $this->validateWidgetSettings($input); }
        public function saveSettings(array $input): array { return $this->prepareSettings($input); }
        public function hasSettings(): bool { return true; }
        public function getDefaultWidth(): int { return 6; }
        public function getMinWidth(): int { return 4; }
        public function getButtons(): array { return []; }
        public function handleAction(string $action, ?string $widgetId = null): array { return ['success' => false, 'message' => 'Action not supported']; }
        public function getCategory(): string { return 'hnspts'; }

        private function settingsDefinition(): array
        {
            return [
                'title' => ['type' => 'text', 'label' => __('hnspts.admin.fields.widget_title'), 'default' => (string) config('hnspts.widget.title', 'PTS Top')],
                'limit' => ['type' => 'number', 'label' => __('hnspts.admin.fields.widget_limit'), 'default' => (int) config('hnspts.widget.limit', 5), 'min' => 1, 'max' => 20],
                'show_wins' => ['type' => 'boolean', 'label' => __('hnspts.admin.fields.widget_show_wins'), 'default' => (bool) config('hnspts.widget.show_wins', true)],
                'show_view_all' => ['type' => 'boolean', 'label' => __('hnspts.admin.fields.widget_show_view_all'), 'default' => (bool) config('hnspts.widget.show_view_all', true)],
            ];
        }

        private function renderWidget(array $settings): ?string
        {
            /** @var PtsService $service */
            $service = app(PtsService::class);
            $prepared = $this->prepareSettings($settings);

            return view('hnspts::widgets.top', [
                'title' => $prepared['title'] !== '' ? $prepared['title'] : __('hnspts.widget.name'),
                'items' => $service->getTop($prepared['limit']),
                'showWins' => $prepared['show_wins'],
                'showViewAll' => $prepared['show_view_all'],
            ])->render();
        }

        private function validateWidgetSettings(array $input): true|array
        {
            $errors = [];
            $limit = isset($input['limit']) ? (int) $input['limit'] : 5;
            if ($limit < 1 || $limit > 20) {
                $errors['limit'] = 'Limit must be between 1 and 20.';
            }
            return empty($errors) ? true : $errors;
        }

        private function prepareSettings(array $settings): array
        {
            return [
                'title' => trim((string) ($settings['title'] ?? config('hnspts.widget.title', 'PTS Top'))),
                'limit' => max(1, min(20, (int) ($settings['limit'] ?? config('hnspts.widget.limit', 5)))),
                'show_wins' => $this->toBool($settings['show_wins'] ?? config('hnspts.widget.show_wins', true)),
                'show_view_all' => $this->toBool($settings['show_view_all'] ?? config('hnspts.widget.show_view_all', true)),
            ];
        }

        private function toBool(mixed $value): bool
        {
            if (is_bool($value)) { return $value; }
            if (is_string($value)) { return in_array(strtolower($value), ['1', 'true', 'yes', 'on'], true); }
            return (bool) $value;
        }
    }
} elseif (interface_exists(\Flute\Core\Widgets\WidgetInterface::class)) {
    class HnsPtsTopWidget implements \Flute\Core\Widgets\WidgetInterface
    {
        public function getName(): string { return __('hnspts.widget.name'); }
        public function getDescription(): string { return __('hnspts.widget.description'); }
        public function getIcon(): string { return '<x-icon path="ph.bold.chart-line-up-bold" />'; }
        public function getSettings(): array { return $this->settingsDefinition(); }
        public function render(array $settings): ?string { return $this->renderWidget($settings); }
        public function renderSettingsForm(array $settings): string|bool { return false; }
        public function validateSettings(array $input): true|array { return $this->validateWidgetSettings($input); }
        public function saveSettings(array $input): array { return $this->prepareSettings($input); }
        public function hasSettings(): bool { return true; }
        public function getDefaultWidth(): int { return 6; }
        public function getMinWidth(): int { return 4; }
        public function getButtons(): array { return []; }
        public function handleAction(string $action, ?string $widgetId = null): array { return ['success' => false, 'message' => 'Action not supported']; }
        public function getCategory(): string { return 'hnspts'; }

        private function settingsDefinition(): array
        {
            return [
                'title' => ['type' => 'text', 'label' => __('hnspts.admin.fields.widget_title'), 'default' => (string) config('hnspts.widget.title', 'PTS Top')],
                'limit' => ['type' => 'number', 'label' => __('hnspts.admin.fields.widget_limit'), 'default' => (int) config('hnspts.widget.limit', 5), 'min' => 1, 'max' => 20],
                'show_wins' => ['type' => 'boolean', 'label' => __('hnspts.admin.fields.widget_show_wins'), 'default' => (bool) config('hnspts.widget.show_wins', true)],
                'show_view_all' => ['type' => 'boolean', 'label' => __('hnspts.admin.fields.widget_show_view_all'), 'default' => (bool) config('hnspts.widget.show_view_all', true)],
            ];
        }

        private function renderWidget(array $settings): ?string
        {
            /** @var PtsService $service */
            $service = app(PtsService::class);
            $prepared = $this->prepareSettings($settings);

            return view('hnspts::widgets.top', [
                'title' => $prepared['title'] !== '' ? $prepared['title'] : __('hnspts.widget.name'),
                'items' => $service->getTop($prepared['limit']),
                'showWins' => $prepared['show_wins'],
                'showViewAll' => $prepared['show_view_all'],
            ])->render();
        }

        private function validateWidgetSettings(array $input): true|array
        {
            $errors = [];
            $limit = isset($input['limit']) ? (int) $input['limit'] : 5;
            if ($limit < 1 || $limit > 20) {
                $errors['limit'] = 'Limit must be between 1 and 20.';
            }
            return empty($errors) ? true : $errors;
        }

        private function prepareSettings(array $settings): array
        {
            return [
                'title' => trim((string) ($settings['title'] ?? config('hnspts.widget.title', 'PTS Top'))),
                'limit' => max(1, min(20, (int) ($settings['limit'] ?? config('hnspts.widget.limit', 5)))),
                'show_wins' => $this->toBool($settings['show_wins'] ?? config('hnspts.widget.show_wins', true)),
                'show_view_all' => $this->toBool($settings['show_view_all'] ?? config('hnspts.widget.show_view_all', true)),
            ];
        }

        private function toBool(mixed $value): bool
        {
            if (is_bool($value)) { return $value; }
            if (is_string($value)) { return in_array(strtolower($value), ['1', 'true', 'yes', 'on'], true); }
            return (bool) $value;
        }
    }
}
