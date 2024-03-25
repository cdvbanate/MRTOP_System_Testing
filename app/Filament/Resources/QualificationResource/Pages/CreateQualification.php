<?php

namespace App\Filament\Resources\QualificationResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\QualificationResource;

class CreateQualification extends CreateRecord
{
    protected static string $resource = QualificationResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Qualification Created';
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
        ->success()
        ->title('Qualification Created')
        ->body('The Qualification created successfully');
    }
}
