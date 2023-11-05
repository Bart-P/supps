<x-filament-panels::page>
    {{-- TODO make some headings and sections --}}
    {{ $this->getInfolist }}
    {{ $this->table }}
    <livewire:list-items :inquiry_id="$record->id" />
</x-filament-panels::page>
