<?php

namespace App\Filament\Resources\SupplierInquiryResource\Pages;

use App\Filament\Resources\SupplierInquiryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSupplierInquiry extends EditRecord
{
    protected static string $resource = SupplierInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
