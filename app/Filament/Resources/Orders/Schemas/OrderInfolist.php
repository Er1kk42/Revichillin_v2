<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Objednávka')
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        TextEntry::make('order_number')
                            ->label('Číslo objednávky'),
                        TextEntry::make('created_at')
                            ->label('Vytvorená')
                            ->dateTime('d.m.Y H:i'),
                        TextEntry::make('total_price')
                            ->label('Celková cena')
                            ->money('EUR')
                            ->weight('bold'),
                    ]),
                Section::make('Zákazník')
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Meno'),
                        TextEntry::make('user.email')
                            ->label('E-mail')
                            ->copyable(),
                    ]),
            ]);
    }
}
