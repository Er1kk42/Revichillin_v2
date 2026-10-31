<?php

namespace App\Filament\Resources\Brands;

use App\Filament\Resources\Brands\Pages\ManageBrands;
use App\Filament\Support\LookupResource;
use App\Models\Brand;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class BrandResource extends LookupResource
{
    protected static ?string $model = Brand::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static ?string $modelLabel = 'značka';

    protected static ?string $pluralModelLabel = 'značky';

    protected static ?int $navigationSort = 2;

    public static function getPages(): array
    {
        return [
            'index' => ManageBrands::route('/'),
        ];
    }
}
