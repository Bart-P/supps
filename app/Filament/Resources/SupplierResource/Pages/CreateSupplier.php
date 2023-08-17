<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use App\Filament\Resources\SupplierResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSupplier extends CreateRecord
{
    protected static string $resource = SupplierResource::class;

    // redirect to back to list on save instead of edit page
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
