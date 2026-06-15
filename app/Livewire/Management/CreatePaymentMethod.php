<?php

namespace App\Livewire\Management;

use App\Models\PaymentMethod;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Schemas\Schema;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class CreatePaymentMethod extends Component implements HasActions, HasSchemas
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
                Section::make('Create New Payment Method')
                    ->description('Fill in the details for the new payment method.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->unique()
                            ->validationMessages(['unique' => 'This Payment Method is already taken, please use a different one.']),
                        TextInput::make('description')
                            ->default(null),
                ])
            ])
            ->statePath('data')
            ->model(PaymentMethod::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        $record = PaymentMethod::create($data);

        $this->form->model($record)->saveRelationships();
            Notification::make()
                ->title('Item Created successfully')
                ->success()
                ->body("Item has been created successfully")
                ->send();

    }

    public function render(): View
    {
        return view('livewire.management.create-payment-method');
    }
}
