<x-filament-panels::page>

    <div class="mb-4">
        {{ $this->form }}
    </div>
    <div class="w-62">
        <x-filament::button wire:click="create">
            Submit
        </x-filament::button>
    </div>



</x-filament-panels::page>
