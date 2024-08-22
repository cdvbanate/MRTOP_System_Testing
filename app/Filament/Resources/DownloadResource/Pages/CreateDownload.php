<?php

namespace App\Filament\Resources\DownloadResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\DownloadResource;

class CreateDownload extends CreateRecord
{
    protected static string $resource = DownloadResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Document Created';
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
        ->success()
        ->title('Document Created')
        ->body('The Document created successfully');
    }
}
