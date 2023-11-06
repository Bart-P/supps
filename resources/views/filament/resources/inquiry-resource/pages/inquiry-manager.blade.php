<x-filament-panels::page>
    {{ $this->getInfolist }}

    <livewire:list-items :inquiry_id="$record->id" />

    <h3 class="ps-2 font-bold">
        Supplier Inquiries
    </h3>
    {{ $this->table }}
</x-filament-panels::page>
