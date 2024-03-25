<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Qualification;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\QualificationResource\Pages;
use App\Filament\Resources\QualificationResource\RelationManagers;

class QualificationResource extends Resource
{
    protected static ?string $model = Qualification::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';
    protected static ?string $modelLabel= 'List of Qualifications';
    protected static ?int $navigationSort = 3;

    // protected static ?string $navigationGroup = 'Course Management';
    public static function form(Form $form): Form
    {
        return $form
        ->schema([

            Forms\Components\Section::make('Qualification Information')
            ->description('Please provide complete data here')
            ->schema([  
            Forms\Components\TextInput::make('qualification_name')
                ->label('MRTOP Qualification')
                ->required()
                ->unique()
                ->maxLength(255),

            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        
            ->columns([
                Tables\Columns\TextColumn::make('qualification_name')
                    ->label('MRTOP Qualification')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function Infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
            Section::make('MRTOP Course Information')
              ->schema([
                TextEntry::make('qualification_name')->label('Qualification Name'),
              ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQualifications::route('/'),
            'create' => Pages\CreateQualification::route('/create'),
            // 'view' => Pages\ViewQualification::route('/{record}'),
            'edit' => Pages\EditQualification::route('/{record}/edit'),
        ];
    }
}
