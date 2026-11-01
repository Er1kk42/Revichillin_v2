<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Filament\Support\LookupResource;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Základné údaje')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Názov')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Popis')
                            ->rows(5)
                            ->columnSpanFull(),
                    ]),

                Section::make('Cena a sklad')
                    ->columnSpanFull()
                    ->columns(3)
                    ->schema([
                        TextInput::make('price')
                            ->label('Cena')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(999999.99)
                            ->step(0.01)
                            ->suffix('€'),
                        TextInput::make('stock')
                            ->label('Počet kusov na sklade')
                            ->required()
                            ->integer()
                            ->minValue(0)
                            ->default(0),
                        TextInput::make('nicotine_strength')
                            ->label('Obsah nikotínu')
                            ->integer()
                            ->minValue(0)
                            ->suffix('mg')
                            ->helperText('Nechaj prázdne pri produktoch bez nikotínu.'),
                    ]),

                Section::make('Zaradenie')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        Select::make('product_type_id')
                            ->label('Typ produktu')
                            ->relationship('productType', 'name')
                            ->createOptionForm(LookupResource::formComponents())
                            ->required()
                            ->preload(),
                        Select::make('brand_id')
                            ->label('Značka')
                            ->relationship('brand', 'name')
                            ->createOptionForm(LookupResource::formComponents())
                            ->searchable()
                            ->preload(),
                        Select::make('flavors')
                            ->label('Príchute')
                            ->relationship('flavors', 'name')
                            ->createOptionForm(LookupResource::formComponents())
                            ->multiple()
                            ->preload(),
                        Select::make('categories')
                            ->label('Kategórie')
                            ->relationship('categories', 'name')
                            ->createOptionForm(LookupResource::formComponents())
                            ->multiple()
                            ->preload(),
                    ]),

                Section::make('Obrázok')
                    ->columnSpanFull()
                    ->schema([
                        FileUpload::make('image')
                            ->hiddenLabel()
                            ->disk('products')
                            ->image()
                            ->maxSize(2048),
                    ]),
            ]);
    }
}
