<?php

namespace App\Filament\Resources\ProductListingResource\Pages;

use App\Filament\Resources\ProductListingResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageProductListings extends ManageRecords
{
    protected static string $resource = ProductListingResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
