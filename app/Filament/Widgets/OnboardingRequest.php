<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Request;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Widgets\TableWidget as BaseWidget;

class OnboardingRequest extends BaseWidget
{
    protected static ?int $sort = 4;
    
    protected int | string | array $columnSpan ='full';
    public function table(Table $table): Table
    {
        {

           
            return $table
                ->query(Request::query())
                ->defaultSort('created_at', 'desc')
                ->modifyQueryUsing(function (Builder $query) {
                    $user = Auth::user();
                    if ($user->role === 'ADMIN') {
                        return;
                    }
                    $userId = $user->id;
                    $query->where('user_id', $userId);
                })
                ->columns([
                    Tables\Columns\TextColumn::make('qualification.qualification_name'),
                    // Tables\Columns\TextColumn::make('NameOfTrainer')->label('Name of Trainer'),
                    // Tables\Columns\TextColumn::make('institution_name')->label('Technology Institutiton Name (TTIs)'),
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
                    ->dateTime()
                    ->label('Date Requested')
                    ->sortable(), 
                    Tables\Columns\TextColumn::make('Remarks') 
                ]);  
            }
    }
    public static function canView(): bool
    {
        return auth()->user()->isEditor();
    }
}
