<?php

namespace App\Filament\Resources\Orders\RelationManagers;

use App\Models\OrderItem;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Položky objednávky';

    public function isReadOnly(): bool
    {
        return true;
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('product.name')
                    ->label('Produkt'),
                TextColumn::make('quantity')
                    ->label('Množstvo'),
                TextColumn::make('price')
                    ->label('Cena za kus')
                    ->money('EUR'),
                TextColumn::make('subtotal')
                    ->label('Spolu')
                    ->state(fn (OrderItem $record) => $record->quantity * $record->price)
                    ->money('EUR'),
            ])
            ->paginated(false);
    }
}
