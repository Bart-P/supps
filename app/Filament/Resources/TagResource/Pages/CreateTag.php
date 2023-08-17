<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTag extends CreateRecord
{
    protected static string $resource = TagResource::class;

    // redirect to back to list on save instead of edit page
    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
