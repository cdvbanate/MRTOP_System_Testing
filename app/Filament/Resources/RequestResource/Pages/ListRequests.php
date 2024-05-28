<?php

namespace App\Filament\Resources\RequestResource\Pages;

use Filament\Actions;
use App\Models\Request;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\RequestResource;



class ListRequests extends ListRecords
{
    protected static string $resource = RequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            
        ];
    }

    protected ?string $heading = 'MRTOP Request for Onboarding';
    protected ?string $subheading = 'List of Approved and For Verfication MRTOP request';

    public function getTabs(): array
    {
        $user = Auth::user();
        
        return [
            'All' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) use ($user) {
                    if ($user->role !== 'ADMIN') {
                        $query->where('user_id', $user->id);
                    }
                })
                ->badge(function() use ($user) {
                    $query = Request::query();
                    if ($user->role !== 'ADMIN') {
                        $query = $query->where('user_id', $user->id);
                    }
                    return $query->count();
                }),
                
            'This Week' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) use ($user) {
                    if ($user->role !== 'ADMIN') {
                        $query->where('user_id', $user->id);
                    }
                    $query->where('created_at', '>=', now()->subWeek());
                })
                ->badge(function() use ($user) {
                    $query = Request::query()->where('created_at', '>=', now()->subWeek());
                    if ($user->role !== 'ADMIN') {
                        $query = $query->where('user_id', $user->id);
                    }
                    return $query->count();
                }),
                
            'This Month' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) use ($user) {
                    if ($user->role !== 'ADMIN') {
                        $query->where('user_id', $user->id);
                    }
                    $query->where('created_at', '>=', now()->subMonth());
                })
                ->badge(function() use ($user) {
                    $query = Request::query()->where('created_at', '>=', now()->subMonth());
                    if ($user->role !== 'ADMIN') {
                        $query = $query->where('user_id', $user->id);
                    }
                    return $query->count();
                }),
                
            'This Year' => Tab::make()
                ->modifyQueryUsing(function (Builder $query) use ($user) {
                    if ($user->role !== 'ADMIN') {
                        $query->where('user_id', $user->id);
                    }
                    $query->where('created_at', '>=', now()->subYear());
                })
                ->badge(function() use ($user) {
                    $query = Request::query()->where('created_at', '>=', now()->subYear());
                    if ($user->role !== 'ADMIN') {
                        $query = $query->where('user_id', $user->id);
                    }
                    return $query->count();
                }),
        ];
    }
}
