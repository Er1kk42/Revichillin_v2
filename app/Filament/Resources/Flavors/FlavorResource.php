<?php

namespace App\Filament\Resources\Flavors;

use App\Filament\Resources\Flavors\Pages\ManageFlavors;
use App\Filament\Support\LookupResource;
use App\Models\Flavor;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class FlavorResource extends LookupResource
{
    protected static ?string $model = Flavor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static ?string $modelLabel = 'príchuť';

    protected static ?string $pluralModelLabel = 'príchute';

    protected static ?int $navigationSort = 3;

    public static function getPages(): array
    {
        return [
            'index' => ManageFlavors::route('/'),
        ];
    }
}
