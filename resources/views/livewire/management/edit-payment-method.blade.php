<div>
    <form wire:submit="save">
        {{ $this->form }}

        <x-filament::button type="submit" size="lg" class="mt-3 " icon="heroicon-m-pencil-square">
            Edit
        </x-filament::button>
    </form>

    <x-filament-actions::modals />
</div>
