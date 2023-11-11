<?php

namespace App\Filament\Resources\InquiryResource\Pages;

use App\Filament\Resources\InquiryResource;
use App\Models\Inquiry;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\EditRecord;

class EditInquiry extends EditRecord
{
    protected static string $resource = InquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Action::make('manage')
            ->icon('heroicon-o-clipboard-document-list')
            ->color('success')
            ->url(fn (Inquiry $record): string => route(
                'filament.admin.resources.inquiries.manage',
                $record
            )),
        ];
    }
}
