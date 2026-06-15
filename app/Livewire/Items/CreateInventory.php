<?php

namespace App\Livewire\Items;

use App\Models\Inventory;
use App\Models\Item;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CreateInventory extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Create New Inventory')
                    ->description('Fill in the details for the new inventory entry.')                    ->columns(2)
                    ->schema([

                Select::make('item_id')
                    ->required()
                    ->relationship('item', 'name')
                    ->exists(table: Item::class, column: 'id')
                    ->searchable()
                    ->preload(),

                    TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(0),
                ])
            ])
            ->statePath('data')
            ->model(Inventory::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = Inventory::create($data);

        $this->form->model($record)->saveRelationships();

        Notification::make()
            ->title('Inventory Created successfully')
            ->success()
            ->body("Inventory has been created successfully")
            ->send();

    }

    public function render(): View
    {
        return view('livewire.items.create-inventory');
    }
}
