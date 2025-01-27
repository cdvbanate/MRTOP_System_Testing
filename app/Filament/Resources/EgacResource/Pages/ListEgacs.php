<?php

namespace App\Filament\Resources\EgacResource\Pages;

use App\Filament\Resources\EgacResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEgacs extends ListRecords
{
    protected static string $resource = EgacResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
