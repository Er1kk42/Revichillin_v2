<?php

namespace App\Filament\Resources\Products\Tables;

use App\Models\Product;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withExists('orderItems'))
            ->columns([
                ImageColumn::make('image')
                    ->label('')
                    ->disk('products')
                    ->square(),
                TextColumn::make('name')
                    ->label('Názov')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('brand.name')
                    ->label('Značka')
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('productType.name')
                    ->label('Typ')
                    ->sortable(),
                TextColumn::make('price')
                    ->label('Cena')
                    ->money('EUR')
                    ->sortable(),
                TextColumn::make('stock')
                    ->label('Sklad')
                    ->badge()
                    ->color(fn (int $state): string => $state > 0 ? 'success' : 'danger')
                    ->sortable(),
                TextColumn::make('nicotine_strength')
                    ->label('Nikotín')
                    ->suffix(' mg')
                    ->placeholder('—')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Upravené')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->filters([
                SelectFilter::make('brand')
                    ->label('Značka')
                    ->relationship('brand', 'name'),
                SelectFilter::make('productType')
                    ->label('Typ produktu')
                    ->relationship('productType', 'name'),
                SelectFilter::make('categories')
                    ->label('Kategória')
                    ->relationship('categories', 'name')
                    ->multiple(),
                Filter::make('out_of_stock')
                    ->label('Len vypredané')
                    ->toggle()
                    ->query(fn (Builder $query) => $query->where('stock', 0)),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->hidden(fn (Product $record): bool => $record->order_items_exists),
            ]);
    }
}
