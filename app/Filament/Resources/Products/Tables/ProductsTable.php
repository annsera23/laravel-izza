<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Image')
                    ->circular()
                    ->size(40),

                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->width('18%'),

                TextColumn::make('category.name')
                    ->label('Category')
                    ->searchable()
                    ->width('15%'),

                TextColumn::make('price')
                    ->label('Price')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->width('15%'),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(45)
                    ->wrap()
                    ->width('35%'),
            ])

            ->actions([
                EditAction::make()
                    ->label('Edit'),
            ])

            ->filters([])

            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])

            ->paginated([10, 25, 50]);
    }
}