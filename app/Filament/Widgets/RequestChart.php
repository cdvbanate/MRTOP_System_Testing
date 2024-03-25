<?php

namespace App\Filament\Widgets;

use App\Models\Request;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;

class RequestChart extends ChartWidget
{
    protected static ?string $heading = 'Status of Onboarding Request';

    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '300px';

    protected int | string | array $columnSpan ='full';
    protected static string $color = 'warning';

    protected function getData(): array
    {
        $data = Trend::model(Request::class)
        ->between(
            start: now()->startOfMonth(),
            end: now()->endOfMonth(),
        )
        ->perDay()
        ->count();
 
    return [
        'datasets' => [
            [
                'label' => 'Request Per Day',
                'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                
            ],
        ],
        'labels' => $data->map(fn (TrendValue $value) => $value->date),
    ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public static function canView(): bool
    {
        return auth()->user()->isAdmin();
    }
}
