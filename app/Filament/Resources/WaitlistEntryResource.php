<?php

namespace App\Filament\Resources;

use App\Models\WaitlistEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class WaitlistEntryResource extends Resource
{
    protected static ?string $model = WaitlistEntry::class;

    protected static ?string $navigationLabel = 'Launch list';

    protected static string|\UnitEnum|null $navigationGroup = 'Wiener Box';

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-envelope';

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('email')->searchable(),
            Tables\Columns\TextColumn::make('postcode')->searchable(),
            Tables\Columns\TextColumn::make('interest')->badge(),
            Tables\Columns\TextColumn::make('consented_at')->dateTime()->sortable(),
        ])->filters([
            Tables\Filters\SelectFilter::make('interest')->options(['subscription' => 'Subscription', 'gift' => 'Gift', 'shop' => 'Shop']),
        ])->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return ['index' => WaitlistEntryResource\Pages\ListWaitlistEntries::route('/')];
    }
}
