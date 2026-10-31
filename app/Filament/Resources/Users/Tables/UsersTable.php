<?php

namespace App\Filament\Resources\Users\Tables;

use App\Filament\Resources\Users\Schemas\UserForm;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Meno')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('E-mail')
                    ->searchable(),
                TextColumn::make('role')
                    ->label('Rola')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => UserForm::ROLES[$state] ?? $state)
                    ->color(fn (string $state): string => $state === 'admin' ? 'warning' : 'gray'),
                TextColumn::make('birth_date')
                    ->label('Dátum narodenia')
                    ->date('d.m.Y')
                    ->placeholder('—')
                    ->toggleable(),
                TextColumn::make('orders_count')
                    ->label('Objednávky')
                    ->counts('orders')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Registrovaný')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('role')
                    ->label('Rola')
                    ->options(UserForm::ROLES),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->hidden(fn (User $record): bool => $record->is(auth()->user()))
                    ->modalDescription('Spolu s používateľom sa zmažú aj jeho objednávky, recenzie a košík. Túto akciu nie je možné vrátiť.'),
            ]);
    }
}
