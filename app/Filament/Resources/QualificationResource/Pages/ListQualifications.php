<?php

namespace App\Filament\Resources\QualificationResource\Pages;

use Filament\Actions;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use App\Filament\Resources\QualificationResource;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListQualifications extends ListRecords
{
    protected static string $resource = QualificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            ExportAction::make() 
            ->exports([
                ExcelExport::make()
                    ->fromTable()
                    ->withFilename(fn ($resource) => $resource::getModelLabel())
                    ->withWriterType(\Maatwebsite\Excel\Excel::CSV)
            ]), 
        ];
    }

    protected ?string $heading = 'MRTOP Registered Qualifications';
    protected ?string $subheading = 'MasterList of Registered Qualifications';
}
