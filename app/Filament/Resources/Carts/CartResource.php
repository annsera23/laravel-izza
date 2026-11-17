<?php

namespace App\Filament\Resources\Carts;

use App\Filament\Resources\Carts\Pages\EditCart;
use App\Filament\Resources\Carts\Pages\ListCarts;
use App\Filament\Resources\Carts\Schemas\CartForm;
use App\Filament\Resources\Carts\Tables\CartsTable;
use App\Models\Cart;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

class CartResource extends Resource
{
    protected static ?string $model = Cart::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingCart;

    protected static UnitEnum|string|null $navigationGroup = 'Carts & Orders';

    public static function getNavigationSort(): ?int
    {
        return 4;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function form(Schema $schema): Schema
    {
        return CartForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.title')
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer_id')
                    ->searchable(),

                Tables\Columns\TextColumn::make('qty'),

                Tables\Columns\TextColumn::make('total')
                    ->money('IDR', locale: 'id')
                    ->getStateUsing(
                        fn ($record) => $record->qty * $record->product->price
                    ),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => ListCarts::route('/'),
            'edit' => EditCart::route('/{record}/edit'),
        ];
    }
}