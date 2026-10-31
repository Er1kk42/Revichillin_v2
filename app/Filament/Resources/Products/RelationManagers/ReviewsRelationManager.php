<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Actions\DeleteAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReviewsRelationManager extends RelationManager
{
    protected static string $relationship = 'reviews';

    protected static ?string $title = 'Recenzie';

    protected static ?string $modelLabel = 'recenzia';

    protected static ?string $pluralModelLabel = 'recenzie';

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Autor'),
                TextColumn::make('text')
                    ->label('Text')
                    ->wrap(),
                TextColumn::make('created_at')
                    ->label('Pridané')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                DeleteAction::make(),
            ]);
    }
}
