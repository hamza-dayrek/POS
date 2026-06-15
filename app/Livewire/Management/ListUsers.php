<?php

namespace App\Livewire\Management;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Notifications\Notification;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class ListUsers extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithTable;
    use InteractsWithSchemas;

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => User::query())
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                // TextColumn::make('email_verified_at')
                //     ->dateTime()
                //     ->sortable(),
                // TextColumn::make('two_factor_confirmed_at')
                //     ->dateTime()
                //     ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('role')
                    ->searchable()
                    ->badge(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Action::make('create')
                    ->label('Create New User')
                    ->url(fn (): string => route('user.create')),
            ])
            ->recordActions([
                Action::make('edit')
                    ->url(fn (User $record): string => route('user.update', $record)),

                Action::make('delete')
                    ->requiresConfirmation()
                    ->color('danger')
                    ->action(fn (user $record) => $record->delete())
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
        return view('livewire.management.list-users');
    }
}
