<?php

namespace App\Filament\Resources\EgacResource\Pages;

use App\Filament\Resources\EgacResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewEgac extends ViewRecord
{
    protected static string $resource = EgacResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
