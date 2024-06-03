<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected ?string $heading = 'LMS Users';
    protected ?string $subheading = 'MasterList of Learning Management System (LMS) Administrators';

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
                    $query = User::query();
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
                    $query = User::query()->where('created_at', '>=', now()->subWeek());
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
                    $query = User::query()->where('created_at', '>=', now()->subMonth());
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
                    $query = User::query()->where('created_at', '>=', now()->subYear());
                    if ($user->role !== 'ADMIN') {
                        $query = $query->where('user_id', $user->id);
                    }
                    return $query->count();
                }),
        ];

    }
}
