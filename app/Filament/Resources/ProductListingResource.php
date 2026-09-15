<?php

namespace App\Filament\Resources;

use App\Models\ProductListing;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Lunar\Models\Product;

class ProductListingResource extends Resource
{
    protected static ?string $model = ProductListing::class;

    protected static ?string $navigationLabel = 'Storefront listings';

    protected static string|\UnitEnum|null $navigationGroup = 'Wiener Box';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('product_id')->label('Lunar product')->options(fn () => Product::all()->mapWithKeys(fn ($product) => [$product->id => $product->translateAttribute('name') ?? 'Product '.$product->id]))->searchable()->required()->unique(ignoreRecord: true)->disabledOn('edit'),
            TextInput::make('slug')->required()->regex('/^[a-z0-9]+(?:-[a-z0-9]+)*$/')->unique(ignoreRecord: true),
            TextInput::make('eyebrow')->required()->maxLength(80),
            Select::make('category')->options(['subscription' => 'Subscription', 'box' => 'One-off box', 'gift' => 'Gift', 'pack' => 'Individual pack'])->required(),
            Select::make('colour')->options(['mustard' => 'Mustard', 'peach' => 'Peach', 'sage' => 'Sage'])->required(),
            Select::make('cadence')->options(['monthly' => 'Monthly', 'one-off' => 'One-off'])->required(),
            Textarea::make('story')->required()->maxLength(2000),
            TagsInput::make('highlights')->required(), TagsInput::make('contents')->required(),
            TextInput::make('position')->numeric()->integer()->minValue(0)->required(),
            Toggle::make('featured'), Toggle::make('published'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('slug')->searchable(), TextColumn::make('category')->badge(),
            TextColumn::make('cadence'), IconColumn::make('published')->boolean(),
        ])->recordActions([EditAction::make()])->description('Edit product names, prices and inventory under Products. These settings control storefront presentation.');
    }

    public static function getPages(): array
    {
        return ['index' => ProductListingResource\Pages\ManageProductListings::route('/')];
    }
}
