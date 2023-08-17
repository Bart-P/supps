<?php

namespace App\Filament\Resources\PersonResource\Pages;

use App\Filament\Resources\PersonResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePerson extends CreateRecord
{
    protected static string $resource = PersonResource::class;

    // redirect to back to list on save instead of edit page
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
