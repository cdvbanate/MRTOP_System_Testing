<?php

namespace App\Filament\Resources\FilesResource\Pages;

use App\Filament\Resources\FilesResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewFiles extends ViewRecord
{
    protected static string $resource = FilesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
