<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\School;
use App\Models\Request;
use App\Models\Province;
use App\Models\Institution;
use App\Models\Qualification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class RequestStatusPerTTI extends BaseWidget
{
    protected function getStats(): array
    {

        $user = Auth::user();
        $userId = $user->id;
        // Initialize an empty array to store stats
        $stats = [];
       
        $totalApprovedRequests = Request::where('RequestStatus', 'Approved')
        ->where('user_id', $userId)
        ->count();
        $stats[] = Stat::make('Request Approved', $totalApprovedRequests)
            ->description('Total Numbers of Approved Request')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('warning');

        // Count requests for verification
        $totalRequestsForVerification = Request::query()->where('RequestStatus', 'For Verification')
        ->where('user_id', $userId)
        ->count();
        $stats[] = Stat::make('Request For Verification', $totalRequestsForVerification)
            ->description('Total Numbers of Pending Request')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('warning');
        
        $totalTrainingStatus = Request::query()->where('TrainingStatus', 'Ongoing')
            ->where('user_id', $userId)
            ->count();
        $stats[] = Stat::make('Ongoing Training', $totalTrainingStatus)
            ->description('Total Numbers of Ongoing Trainings')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('warning');

        // Return the array of stats
        return $stats;
    }

    public static function canView(): bool
    {
        return auth()->user()->isEditor();
    }

    public function table(Builder $table): Builder
    {
        $user = Auth::user();
        
        if ($user->role !== 'ADMIN') {
            $userId = $user->id;
            $table->query()->where('user_id', $userId);
        }
        
        return $table;
    }
}
