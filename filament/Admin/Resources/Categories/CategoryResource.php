<?php

namespace Filament\Admin\Resources\Categories;

use App\Models\Category;
use BackedEnum;
use Filament\Admin\Resources\Categories\Pages\CreateCategory;
use Filament\Admin\Resources\Categories\Pages\EditCategory;
use Filament\Admin\Resources\Categories\Pages\ListCategories;
use Filament\Admin\Resources\Categories\Pages\ViewCategory;
use Filament\Admin\Resources\Categories\Schemas\CategoryForm;
use Filament\Admin\Resources\Categories\Schemas\CategoryInfolist;
use Filament\Admin\Resources\Categories\Tables\CategoriesTable;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|UnitEnum|null $navigationGroup = 'Savollar';

    protected static ?string $label = 'kategoriya';

    protected static ?string $pluralLabel = 'Kategoriyalar';

    protected static ?string $navigationLabel = 'Kategoriyalar';

    protected static ?int $navigationSort = 1;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedListBullet;

    public static function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema);
    }

    /*public static function infolist(Schema $schema): Schema
    {
        return CategoryInfolist::configure($schema);
    }*/

    public static function table(Table $table): Table
    {
        return CategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'view' => ViewCategory::route('/{record}'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }
}
