<?php

namespace App\Filament\Resources\InquiryResource\Pages;

use App\Filament\Resources\InquiryResource;
use App\Models\Inquiry;
use App\Models\SupplierInquiry;
use Filament\Actions\Action as ActionsAction;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\Action;
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
    public ?array $data = [];

    protected function getHeaderActions(): array
    {
        return [
            ActionsAction::make('edit inquiry')
                ->label('Edit Inquiry')
                ->icon('heroicon-o-clipboard-document-list')
                ->color('primary')
                ->url(route('filament.admin.resources.inquiries.edit', $this->record->id)),
            ActionsAction::make('edit project')
                ->label('Edit Project')
                ->icon('heroicon-o-rectangle-stack')
                ->color('info')
                ->url(route('filament.admin.resources.projects.edit', $this->record->project_id))
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

    public function table(Table $table): Table
    {
        return $table
            ->query(SupplierInquiry::query()
                ->join('suppliers', 'supplier_inquiries.supplier_id', '=', 'suppliers.id')
                ->select('supplier_inquiries.*', 'suppliers.name as supplier_name')
                ->where('inquiry_id', '=', $this->record->id))
            ->columns([
                TextColumn::make('supplier_name')->label('Supplier'),
                TextColumn::make('lang'),
                TextColumn::make('updated_at')
                    ->copyable()
                    ->dateTime('d.m.Y G:i', 'Europe/Berlin'),
                TextColumn::make('created_at')
                    ->copyable()
                    ->dateTime('d.m.Y G:i', 'Europe/Berlin'),
            ])
            ->actions([
                // TODO finish crud for supp inquiry
                Action::make('edit')
                    ->icon('heroicon-o-pencil-square')
                    ->form([
                        TextInput::make('msg_title')
                            ->label('Title'),
                        RichEditor::make('msg_body')
                            ->label('Body'),
                    ])
                    ->action(function () {
                        dd('TODO -> implement mail functionality');
                    })
            ]);
    }
}
