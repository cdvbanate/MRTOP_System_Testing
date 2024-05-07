<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Request;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\RequestResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RequestResource\RelationManagers;

class RequestResource extends Resource
{
    protected static ?string $model = Request::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $navigationLabel = 'Request for Onboarding';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        
        $userOptions = auth()->user()->isAdmin() ?
        User::pluck('name', 'id')->toArray() :
        [Auth::user()->id => Auth::user()->name];

        return $form
            ->schema([
               
                Forms\Components\Section::make('LMS Administrator Status')
                ->description('LMS Administrator Details')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->options($userOptions)
                        ->disabledOn(auth()->user()->isAdmin() ? [] : ['edit'])
                        ->required()
                        ->native(false)
                        ->label('LMS Administrator')
                        ->default(Auth::user()->id),
                ]),
            
                Forms\Components\Section::make('TESDA Technology Institutions Information')
                    // ->disabledOn('create')
                    ->schema([
                        Forms\Components\Select::make('region_name')
                            ->options([
                                Auth::user()->id => Auth::user()->region_name
                            ])
                            ->disabledOn(auth()->user()->isAdmin() ? [] : ['edit'])
                            ->required()
                            ->native(false)
                            ->label('Region')
                            ->default(Auth::user()->region_name),

                        Forms\Components\Select::make('province_name')
                            ->options([
                                Auth::user()->id => Auth::user()->province_name
                            ])
                            ->disabledOn(auth()->user()->isAdmin() ? [] : ['edit'])
                            ->required()
                            ->native(false)
                            ->label('Province')
                            ->default(Auth::user()->province_name),

                        Forms\Components\Select::make('institution_name')
                            ->options([
                                Auth::user()->id => Auth::user()->institution_name
                            ])
                            ->disabledOn(auth()->user()->isAdmin() ? [] : ['edit'])
                            ->required()
                            ->native(false)
                            ->label('TESDA Technology Institution')
                            ->default(Auth::user()->institution_name),

                    ])->columns(3),

                Forms\Components\Section::make('Qualification Information')
                    ->description('Please input complete course and qualification here.')
                    ->disabledOn(auth()->user()->isAdmin() ? [] : ['edit'])
                    ->schema([

                        Forms\Components\Select::make('withExistingTOPcourse')
                            ->required()
                            ->label('With Existing Course?')
                            ->preload()
                            ->native(false)
                            ->options([
                                '1' => 'Yes',
                                '0' => 'No',
                            ]),
                        Forms\Components\Select::make('qualification_id')
                            ->relationship(name: 'qualification', titleAttribute: 'qualification_name')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->label('MRTOP Qualifications')
                            ->live()
                            ->required(),
                        Forms\Components\TextInput::make('Attachment')
                            ->label('Link to Google Drive')
                            ->placeholder('E.g https://drive.google.com/drive/folders/1qrvMhgrne3SUdpwnGYyIvelRf7SOK48E?usp=drive_link')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(1)
                    ]),


                Forms\Components\Section::make('Trainer Information')
                    ->description('Please input the complete Trainer Information here.')
                    ->disabledOn(auth()->user()->isAdmin() ? [] : ['edit'])
                    ->schema([
                        Forms\Components\TextInput::make('NameOfTrainer')
                            ->label('Name of Trainer')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('NTTCNumber')
                            ->label('NTTC Number')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('contactNumber')
                            ->label('Contact Number')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('emailAddress')
                            ->email()
                            ->label('Email Address')
                            ->required()
                            ->maxLength(255),
                    ])->columns(4),


                Forms\Components\Section::make('Schedule of Training')
                    ->description('Please Input your complete data in here')
                    ->schema([
                        Forms\Components\DatePicker::make('targetStart')
                            ->required()

                            ->label('Target Start'),
                        Forms\Components\DatePicker::make('targetEnd')
                            ->required()

                            ->label('Target End'),

                    ])->columns(2),

                Forms\Components\Section::make('Training and Request Status ')
                    ->description('Note: Please update the status once the request is already approved.')
                    ->schema([

                        Forms\Components\Select::make('RequestStatus')
                            ->required()
                            ->label('Request Status')
                            ->preload()
                            ->hidden(!Auth::check() || !Auth::user()->isAdmin())
                            ->native(false)
                            ->options([
                                'For Verification' => 'For Verification',
                                'Approved' => 'Approved',
                             
                            ]),

                            
                        Forms\Components\Select::make('TrainingStatus')

                            ->label('Training Status')
                            ->preload()
                            ->required()
                            ->native(false)
                            ->options([
                                'Not Yet Started' => 'Not Yet Started',
                                'Ongoing' => 'Ongoing',
                                'Completed' => 'Completed',
                            ]) ->disabled('RequestStatus' === 'For Verification'),

                        Forms\Components\TextInput::make('Remarks')
                            ->label('Remarks')
                            ->maxLength(255)
                            ->placeholder('Sample Message')

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

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
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('region_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('province_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('qualification.qualification_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('institution_name')
                    ->searchable(),
                Tables\Columns\IconColumn::make('withExistingTOPcourse')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('targetStart')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('targetEnd')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('NameOfTrainer')
                    ->label('Name of Trainer')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('NTTCNumber')
                    ->label('NTTC Number')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('contactNumber')
                   
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('emailAddress')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('Attachment')
                    ->label('Link to Drive')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('RequestStatus')
                    ->badge()
                    ->label('Request Status')
                    ->color(fn (string $state): string => match ($state) {
                        'For Verification' => 'warning',
                        'Approved' => 'success',
                    }),
                Tables\Columns\TextColumn::make('TrainingStatus')
                    ->badge()
                    ->label('Training Status')
                    ->color(fn (string $state): string => match ($state) {
                        'Not Yet Started' => 'danger',
                        'Ongoing' => 'warning',
                        'Completed' => 'success',
                    }),
                Tables\Columns\TextColumn::make('Remarks')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])->defaultSort(fn($query) => $query->orderBy('RequestStatus', 'desc'))
            ->filters([
                // SelectFilter::make('created_at')
                //     ->label('Filter By Year')
                //     ->preload()
                //     ->indicator('Year'),
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
                Section::make('TTIs and School Information')
                    ->schema([
                        TextEntry::make('institution_name'),
                    ]),

                Section::make('Qualification Information')
                    ->schema([
                        TextEntry::make('qualification.qualification_name')->label('MRTOP Qualifications'),
                        IconEntry::make('withExistingTOPcourse')->label('With Existing Course?')->boolean(),
                        TextEntry::make('targetStart')->label('Target Start')->date(),
                        TextEntry::make('targetEnd')->label('Target End')->date(),
                      
                    ])->columns(4),
                Section::make('Trainer Information')
                    ->schema([
                        TextEntry::make('NameOfTrainer')->label('Name of Trainer'),
                        TextEntry::make('NTTCNumber')->label('NTTC Number'),
                        TextEntry::make('contactNumber')->label('Contact Number'),
                        TextEntry::make('emailAddress')->label('Email Address'),
                    ])->columns(2),

                Section::make('Request Status')
                    ->schema([
                        TextEntry::make('RequestStatus')->label('Request Status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'For Verification' => 'warning',
                            'Approved' => 'success',
                        
                        }),

                        TextEntry::make('TrainingStatus')->label('Training Status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'Not Yet Started' => 'danger',
                            'Ongoing' => 'warning',
                            'Completed' => 'success',
                        }),
                       
                    ])->columns(2),
                Section::make('Link to Google Drive')
                    ->schema([
                    TextEntry::make('Attachment'),
                    ]),

                Section::make('Remarks')
                    ->schema([
                    TextEntry::make('Remarks'),
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
            'index' => Pages\ListRequests::route('/'),
            'create' => Pages\CreateRequest::route('/create'),
            // 'view' => Pages\ViewRequest::route('/{record}'),
            'edit' => Pages\EditRequest::route('/{record}/edit'),
        ];
    }
}
