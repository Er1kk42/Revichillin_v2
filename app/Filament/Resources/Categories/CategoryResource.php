<?php

namespace App\Filament\Resources\Categories;

use App\Filament\Resources\Categories\Pages\ManageCategories;
use App\Filament\Support\LookupResource;
use App\Models\Category;
use BackedEnum;
use Filament\Support\Icons\Heroicon;

class CategoryResource extends LookupResource
{
    protected static ?string $model = Category::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedFolder;

    protected static ?string $modelLabel = 'kategória';

    protected static ?string $pluralModelLabel = 'kategórie';

    protected static ?int $navigationSort = 5;

    public static function getPages(): array
    {
        return [
            'index' => ManageCategories::route('/'),
        ];
    }
}
