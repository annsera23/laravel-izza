<?php

namespace App\Filament\Resources\Ratings;

use App\Filament\Resources\Ratings\Pages\ListRatings;
use App\Filament\Resources\Ratings\Schemas\RatingForm;
use App\Models\Rating;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class RatingResource extends Resource
{
    protected static ?string $model = Rating::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedSparkles;

    protected static string|UnitEnum|null $navigationGroup = 'Ratings & Customers';

    protected static ?string $navigationLabel = 'Ratings & Reviews';

    protected static ?string $pluralNavigationLabel = 'Ratings & Reviews';

    public static function getNavigationSort(): ?int
    {
        return 6;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return RatingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_id')
                    ->searchable(),

                TextColumn::make('product.title')
                    ->searchable(),

                TextColumn::make('rating')
                    ->searchable(),

                TextColumn::make('review')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->searchable(),
            ])
            ->filters([])
            ->recordActions([])
            ->toolbarActions([]);
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
            'index' => ListRatings::route('/'),
        ];
    }
}