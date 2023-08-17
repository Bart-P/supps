<?php

namespace App\Filament\Resources\AddressResource\Pages;

use App\Filament\Resources\AddressResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAddress extends CreateRecord
{
    protected static string $resource = AddressResource::class;

    // redirect to back to list on save instead of edit page
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
