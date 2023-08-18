<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use App\Filament\Resources\SupplierResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSupplier extends EditRecord
{
    protected static string $resource = SupplierResource::class;

    protected $listeners = ['refreshCategoryFields'];

    public function refreshCategoryFields()
    {
        $this->fillForm();
    }

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
