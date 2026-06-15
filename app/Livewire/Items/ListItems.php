<?php

namespace App\Livewire\Items;

use App\Models\Item;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Filament\Actions\Action;
use Filament\Notifications\Notification;



class ListItems extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => Item::query())
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('sku')->searchable()->sortable(),
                TextColumn::make('price')->sortable()->money(),
                TextColumn::make('status')->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('create')
                    ->label('Add New Item')
                    ->url(fn (): string => route('item.create')),
            ])
            ->recordActions([
                Action::make('edit')
                    ->url(fn (Item $record): string => route('item.update', $record)),
                Action::make('delete')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->action(fn (Item $record) => $record->delete())
                    ->successNotification(
                        Notification::make()
                            ->title('Inventory Deleted successfully')
                            ->success()

                    )
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //
                ]),
            ]);
    }

    public function render(): View
    {
        return view('livewire.items.list-items');
    }
}
