<?php

namespace App\Filament\Resources\AddressResource\Pages;

use App\Filament\Resources\AddressResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAddress extends EditRecord
{
    protected static string $resource = AddressResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
