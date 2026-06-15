<div>
    <form wire:submit="create">
        {{ $this->form }}

        <x-filament::button type="submit" size="lg" class="mt-3" icon="heroicon-m-plus-circle">
            Create New Inventory
        </x-filament::button>    </form>
    </form>

    <x-filament-actions::modals />
</div>
