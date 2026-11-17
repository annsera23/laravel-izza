<?php

namespace App\Filament\Resources\Ratings\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RatingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->searchable()
                    ->hidden(),
            ])
            ->filters([])
            ->recordActions([])
            ->toolbarActions([]);
    }
}