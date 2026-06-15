<?php

namespace App\Livewire\Items;

use App\Models\Item;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CreateItem extends Component implements HasActions, HasSchemas
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
                Section::make('Create new item')
                    ->description('Fill in the details for the new item.')
                    ->columns(2)
                    ->schema([

                        TextInput::make('name')
                            ->required(),
                        TextInput::make('sku')
                            ->label('SKU')
                            ->unique(table: Item::class, column: 'sku')
                            ->required(),
                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('$'),
                        ToggleButtons::make('status')
                            ->label('Is this Item Active ?')
                            ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                            ->default('active')
                            ->grouped()
                            ->required(),
                    ])
            ])
            ->statePath('data')
            ->model(Item::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = Item::create($data);

        $this->form->model($record)->saveRelationships();

        Notification::make()
            ->title('Item Created successfully')
            ->success()
            ->body("Item has been created successfully")
            ->send();

    }

    public function render(): View
    {
        return view('livewire.items.create-item');
    }
}
