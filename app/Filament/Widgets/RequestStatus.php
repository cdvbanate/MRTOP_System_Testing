<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Request;
use App\Models\Qualification;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class RequestStatus extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('LMS Administrator', User::query()->count())
                ->description('All LMS Admin in the MRTOP')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

                Stat::make('Total Completed Training', Request::query()->where('TrainingStatus', 'Completed')->count())
                ->description('Total Numbers of Completed Training')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('Total Request for Onboarding', Request::query()->count())
                ->description('Total Numbers of Onboarding Request')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('Request Approved', Request::query()->where('RequestStatus', 'Approved')->count())
                ->description('Total Numbers of Approved Request')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),
            Stat::make('Request For Verification', Request::query()->where('RequestStatus', 'For Verification')->count())
                ->description('Total Numbers of Pending Request')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),
            Stat::make('Ongoing Training', Request::query()->where('TrainingStatus', 'Ongoing')->count())
                ->description('Total Numbers of Ongoing Trainings')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),
        ];
    }

    public static function canView(): bool
    {
        return auth()->user()->isAdmin();
    }
}
