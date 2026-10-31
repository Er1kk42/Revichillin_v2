<?php

namespace App\Filament\Resources\Orders\Tables;

use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label('Číslo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Zákazník')
                    ->searchable(),
                TextColumn::make('user.email')
                    ->label('E-mail')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('items_count')
                    ->label('Položky')
                    ->counts('items'),
                TextColumn::make('total_price')
                    ->label('Spolu')
                    ->money('EUR')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Vytvorená')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Filter::make('created_at')
                    ->schema([
                        DatePicker::make('from')->label('Od'),
                        DatePicker::make('until')->label('Do'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['from'] ?? null, fn (Builder $q, $date) => $q->whereDate('created_at', '>=', $date))
                        ->when($data['until'] ?? null, fn (Builder $q, $date) => $q->whereDate('created_at', '<=', $date))),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
