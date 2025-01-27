<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EgacResource\Pages;
use App\Filament\Resources\EgacResource\RelationManagers;
use App\Models\Egac;
use App\Models\Request;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class EgacResource extends Resource
{
    protected static ?string $model = Egac::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {

        $loggedInUser = Auth::user(); // Get the currently logged-in user

        $userOptions = auth()->user()->isAdmin() ?
        User::pluck('name', 'id')->toArray() :
        [Auth::user()->id => Auth::user()->name];

        return $form

            ->schema([
                Forms\Components\Section::make('LMS Administrator Status')
                    ->description('LMS Administrator Details')
                    ->schema([
                Forms\Components\Select::make('user_id')
                            #->options($userOptions)
                            #->disabledOn(!auth()->user()->isAdmin()) // Disable field if user is not an admin
                            ->default($loggedInUser->name) // Automatically set to the logged-in user's email
                                    ->disabled()
                            ->required()
                            ->native(false)
                            ->label('LMS Administrator'),
                            #->default(Auth::user()->id),

                Forms\Components\Select::make('region_name')
                            #->options([
                                #Auth::user()->id => Auth::user()->region_name
                            #])
                            ->default($loggedInUser->region_name) // Automatically set to the logged-in user's email
                                    ->disabled()
                            #->disabledOn(auth()->user()->isAdmin() ? [] : ['edit'])
                            ->required()
                            ->native(false)
                            ->label('Region')
                            ->default(Auth::user()->region_name),
                Forms\Components\Select::make('institution_name')
                            #->options([
                             #   Auth::user()->id => Auth::user()->region_name
                            #])
                            #->disabledOn(auth()->user()->isAdmin() ? [] : ['edit'])
                            ->default($loggedInUser->institution_name) // Automatically set to the logged-in user's email
                                    ->disabled()
                            ->required()
                            ->native(false)
                            ->label('Institution'),
                            #->default(Auth::user()->region_name),

                Forms\Components\Select::make('qualification_id')
                            ->label("Qualification")
                            ->options(function () use ($loggedInUser) {
                                // Get the qualifications related to the logged-in user’s requests
                                return \App\Models\Qualification::whereIn('id', 
                                    \App\Models\Request::where('user_id', $loggedInUser->id) // Filter by the logged-in user
                                        ->pluck('qualification_id') // Get qualification IDs from the user's requests
                                )
                            ->pluck('qualification_name', 'id'); // Pluck the qualification name and its ID
                            })
                            ->required(),
                Forms\Components\Select::make('NameOfTrainer')
                            ->label("NameOfTrainer")
                            ->placeholder("Select Trainer")
                            ->options(function () use ($loggedInUser) {
                                // Get the targetStart dates related to the logged-in user's requests
                                return \App\Models\Request::where('user_id', $loggedInUser->id) // Filter by logged-in user
                                    ->pluck('NameOfTrainer', 'NameOfTrainer'); // Pluck the unique targetStart dates
                            })
                            ->required(),
                ])
                ->columns(3),

                Forms\Components\Section::make('Training Details')
                ->description('Training Details')
                ->schema([
                Forms\Components\Select::make('Start Date')
                    ->label("Start Date")
                    ->placeholder('Select Date')
                    ->options(function () use ($loggedInUser) {
                        // Get the targetStart dates related to the logged-in user's requests
                        return \App\Models\Request::where('user_id', $loggedInUser->id) // Filter by logged-in user
                            ->pluck('targetStart', 'targetStart'); // Pluck the unique targetStart dates
                    })
                    ->required(),

                    
                Forms\Components\Select::make('targetEnd')
                    ->label("End Date")
                    ->placeholder('Select Date')
                    ->options(function () use ($loggedInUser) {
                        // Get the targetStart dates related to the logged-in user's requests
                        return \App\Models\Request::where('user_id', $loggedInUser->id) // Filter by logged-in user
                            ->pluck('targetEnd', 'targetEnd'); // Pluck the unique targetStart dates
                    })
                    ->required(),
                    Forms\Components\TextArea::make('Remarks')
                    ->maxLength(1000)
                    ->columnSpan('full')
                    ->default(null),

                ])
                ->columns(2),


                Forms\Components\Section::make('EGAC')
                ->description('Please input the count of EGAC here')
                ->schema([
                Forms\Components\TextInput::make('enrolled_female')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('enrolled_male')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('graduate_female')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('graduate_male')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('assessed_female')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('assessed_male')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('completers_female')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('completers_male')
                    ->required()
                    ->numeric(),
                ])

                ->columns(4),

            Forms\Components\Section::make('Training Status')
                ->description('Please input the training Status here')
                ->schema([
                    Forms\Components\Select::make('TrainingStatus')
                    ->label('Training Status')
                    ->placeholder('Select Training Status')
                    ->options([
                        'Not Yet Started' => 'Not Yet Started',
                        'Ongoing' => 'Ongoing',
                        'Completed' => 'Completed',
                    ])
                    ->required()

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('qualification_id')
                ->label('Qualification')
                ->getStateUsing(function ($record) {
                    return $record->qualification->qualification_name; // Display the qualification_name instead of qualification_id
                }),
                Tables\Columns\TextColumn::make('region_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('institution_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('NameOfTrainer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('targetStart')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('targetEnd')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('Remarks')
                    ->searchable(),
                Tables\Columns\TextColumn::make('enrolled_female')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('enrolled_male')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('graduate_female')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('graduate_male')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assessed_female')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('assessed_male')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('completers_female')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('completers_male')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('TrainingStatus')
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEgacs::route('/'),
            'create' => Pages\CreateEgac::route('/create'),
            'view' => Pages\ViewEgac::route('/{record}'),
            'edit' => Pages\EditEgac::route('/{record}/edit'),
        ];
    }
}
