<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Downloadable;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DownloadableResource\Pages;
use App\Filament\Resources\DownloadableResource\RelationManagers;

class DownloadableResource extends Resource
{
    protected static ?string $model = Downloadable::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $modelLabel= 'Downloadable Files';
    
    protected static ?int $navigationSort = 4;


    public static function form(Form $form): Form
    {
        return $form
        ->schema([

            Forms\Components\Section::make('Downloadable File Information')
            ->description('Please provide complete data here.')
            ->schema([  
            Forms\Components\TextInput::make('DocumentName')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('Link')
                ->required()
                ->maxLength(255),
                ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('DocumentName')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Link')
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
            Section::make('Downloadable File Information')
              ->schema([
                TextEntry::make('DocumentName')->label('Document Name'),
                TextEntry::make('Link')->label('Downloadble Link')
                ->copyable()
                ->copyMessage('Copied!')
                ->copyMessageDuration(1500),            
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
            'index' => Pages\ListDownloadables::route('/'),
            'create' => Pages\CreateDownloadable::route('/create'),
            // 'view' => Pages\ViewDownloadable::route('/{record}'),
            'edit' => Pages\EditDownloadable::route('/{record}/edit'),
        ];
    }
}
