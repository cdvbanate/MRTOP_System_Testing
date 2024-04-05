<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Request;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;

class ApprovedRequestLists extends BaseWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan ='full';
    public function table(Table $table): Table
    {
        return $table
            ->query(Request::query())
            ->query(Request::query()->where('RequestStatus', 'Approved')) 
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(function (Builder $query) {
                $user = Auth::user();
            
                if ($user->role === 'ADMIN') {
                    return; // No filtering for ADMIN users
                } elseif ($user->role === 'REGIONAL ADMIN') {
                    $regionName = $user->region_name; // Assuming you have a "region_name" attribute for REGIONAL_ADMIN users
                    $query->where('region_name', $regionName);
                } else {
                    $userId = $user->id;
                    $query->where('user_id', $userId);
                }
            })
            ->columns([

                Tables\Columns\TextColumn::make('qualification.qualification_name'),
                Tables\Columns\TextColumn::make('NameOfTrainer')
                ->label('Trainer'),
                Tables\Columns\TextColumn::make('targetStart'),
                Tables\Columns\TextColumn::make('targetEnd'),
                Tables\Columns\TextColumn::make('RequestStatus')
                ->badge()
                    ->label('Request Status')
                    ->color(fn (string $state): string => match ($state) {
                        'For Verification' => 'warning',
                        'reviewing' => 'danger',
                        'Approved' => 'success',
                        'Decline' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('TrainingStatus')
                ->label('Training Status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'Not Yet Started' => 'danger',
                    'Ongoing' => 'warning',
                    'Completed' => 'success',
                }),
                Tables\Columns\TextColumn::make('created_at')
                ->label('Date Requested')
                ->sortable(), 
               
            ]);   
    }

    public static function canView(): bool
    {
        return auth()->user()->isRegional();
    }
}
