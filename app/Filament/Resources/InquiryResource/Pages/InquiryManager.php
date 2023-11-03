<?php

namespace App\Filament\Resources\InquiryResource\Pages;

use App\Filament\Resources\InquiryResource;
use App\Models\Inquiry;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Collection;

class InquiryManager extends Page
{
    protected static string $resource = InquiryResource::class;

    protected static string $view = 'filament.resources.inquiry-resource.pages.inquiry-manager';

    public ?Inquiry $record;
    public ?Collection $items;
    public ?Collection $supplierInquiries;

    public function mount(): void
    {
        $this->items = $this->record->items()->get();
    }

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
