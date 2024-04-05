<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Information')
                    ->description('Please provide the Learning Management System (LMS) credentials here.')
                    ->schema([
                Forms\Components\TextInput::make('name')
                    ->unique(User::class, 'name', ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->unique(User::class, 'email', ignoreRecord: true)
                    ->required()
                    ->maxLength(255),
                // Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Section::make('TTI Information Details')
                    ->description('Please provide the Learning Management System (LMS) credentials here.')
                    ->schema([
                
                    Forms\Components\Select::make('region_name')
                    ->label('Region')
                    ->options([
                        'NCR' => 'NCR',
                        'CAR' => 'CAR',
                        'Region I' => 'Region I',
                        'Region II' => 'Region II',
                        'Region III' => 'Region III',
                        'Region IV-A' => 'Region IV-A',
                        'Region IV-B' => 'Region IV-B',
                        'Region V' =>  'Region V',
                        'Region VI' =>'Region VI',
                        'Region VII' => 'Region VII',
                        'Region VIII' => 'Region VIII',
                        'Region IX' => 'Region IX',
                        'Region X' => 'Region X',
                        'Region XI' => 'Region XI',
                        'Region XII' => 'Region XII',
                        'Region XIII' => 'Region XIII',
                        'BARMM' => 'BARMM',

                    ])
                    ->native(false)
                    ->required(),
                
                Forms\Components\TextInput::make('province_name')
                    ->label('Provincial Office')
                    ->required()
                    
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('institution_name')
                    ->label('Institution Name')
                    ->required()
                    ->unique(User::class, 'institution_name', ignoreRecord: true)
                    ->maxLength(255),
                Forms\Components\Select::make('role')
                    ->options(User::ROLES)
                    ->required()
                    ->native(false),
                    ])->columns(2)
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('LMS Administrator')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('LMS Email Address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('region_name')
                    ->label('Region')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('province_name')
                    ->label('Province')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('institution_name')
                    ->label('TESDA Technology Institution')
                    ->searchable(),
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
            Section::make('LMS Credentials')
              ->schema([
                TextEntry::make('name')->label('LMS Admin Name'),
                TextEntry::make('email')->label('LMS Email Address'),
                TextEntry::make('region_name')->label('Region Name'),
                TextEntry::make('province_name')->label('Provincial Name'),
                TextEntry::make('institution_name')->label('TESDA Technology Institution'),
              ])->columns(2)
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            // 'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
