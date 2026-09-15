<?php

namespace App\Filament\Resources;

use App\Models\DeliveryArea;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DeliveryAreaResource extends Resource
{
    protected static ?string $model = DeliveryArea::class;

    protected static string|\UnitEnum|null $navigationGroup = 'Wiener Box';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-truck';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('postcode')->required()->regex('/^[0-9]{4}$/')->unique(ignoreRecord: true),
            TextInput::make('suburb')->required()->maxLength(255),
            Select::make('status')->options(['planned' => 'Planned', 'paused' => 'Paused'])->required()->default('planned'),
            TextInput::make('price')->label('Proposed delivery (AUD cents)')->numeric()->integer()->minValue(0)->required()->default(1200),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('postcode')->searchable(), TextColumn::make('suburb')->searchable(),
            TextColumn::make('status')->badge(), TextColumn::make('price')->money('AUD', divideBy: 100),
        ])->recordActions([EditAction::make()]);
    }

    public static function getPages(): array
    {
        return ['index' => DeliveryAreaResource\Pages\ManageDeliveryAreas::route('/')];
    }
}
