<?php

namespace App\Filament\Resources\ProductTypes;

use App\Filament\Resources\ProductTypes\Pages\ManageProductTypes;
use App\Filament\Support\LookupResource;
use App\Models\ProductType;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class ProductTypeResource extends LookupResource
{
    protected static ?string $model = ProductType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static ?string $modelLabel = 'typ produktu';

    protected static ?string $pluralModelLabel = 'typy produktov';

    protected static ?int $navigationSort = 4;

    protected static bool $blockDeleteWhenUsed = true;

    public static function getPages(): array
    {
        return [
            'index' => ManageProductTypes::route('/'),
        ];
    }
}
