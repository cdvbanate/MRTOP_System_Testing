<?php

namespace App\Filament\Resources\EgacResource\Pages;

use App\Filament\Resources\EgacResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEgac extends EditRecord
{
    protected static string $resource = EgacResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
