<?php

namespace App\Filament\Resources\InquiryResource\Pages;

use App\Filament\Resources\InquiryResource;
use App\Models\Inquiry;
use App\Models\SupplierInquiry;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class InquiryManager extends Page implements HasForms, HasInfolists, HasTable
{
    use InteractsWithInfolists;
    use InteractsWithForms;
    use InteractsWithTable;

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
            // ...
        ];
    }

    public function inquiryInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([
                Fieldset::make('Data')
                ->schema([
                    TextEntry::make('id')->copyable(),
                    TextEntry::make('name')->copyable(),
                    TextEntry::make('project_id')->copyable(),
                    TextEntry::make('project.name')->copyable(),
                    TextEntry::make('updated_at')
                        ->copyable()
                        ->dateTime('d.m.Y G:i', 'Europe/Berlin'),
                    TextEntry::make('created_at')
                        ->copyable()
                        ->dateTime('d.m.Y G:i', 'Europe/Berlin'),
                ])->columns(6),
            ]);
    }

    public function getInfolist(string $name): ?Infolist
    {
        return $this->inquiryInfolist(new Infolist());
    }
}
