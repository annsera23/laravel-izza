<?php

namespace App\Filament\Resources\Products;

use App\Filament\Resources\Products\Pages\CreateProduct;
use App\Filament\Resources\Products\Pages\EditProduct;
use App\Filament\Resources\Products\Pages\ListProducts;
use App\Models\Product;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static UnitEnum|string|null $navigationGroup = 'Master Data';

    public static function getNavigationSort(): ?int
    {
        return 2;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        FileUpload::make('image')
                            ->label('Product Image')
                            ->placeholder('Product Image')
                            ->required(),

                        TextInput::make('title')
                            ->label('Product Title')
                            ->placeholder('Product Title')
                            ->required(),

                        Grid::make(3)
                            ->schema([
                                Select::make('category_id')
                                    ->label('Category')
                                    ->relationship('category', 'name')
                                    ->required(),

                                TextInput::make('price')
                                    ->label('Price')
                                    ->placeholder('Price')
                                    ->numeric()
                                    ->required(),

                                TextInput::make('weight')
                                    ->label('Weight')
                                    ->placeholder('Weight')
                                    ->required(),
                            ]),

                        RichEditor::make('description')
                            ->label('Product Description')
                            ->placeholder('Product Description')
                            ->required()
                            ->extraInputAttributes([
                                'style' => 'min-height: 180px;',
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->circular()
                    ->size(40),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->width('18%'),

                Tables\Columns\TextColumn::make('category.name')
                    ->searchable()
                    ->width('15%'),

                Tables\Columns\TextColumn::make('price')
                    ->prefix('Rp ')
                    ->formatStateUsing(
                        fn ($state) => number_format((int) $state, 0, ',', '.')
                    )
                    ->width('15%'),

                Tables\Columns\TextColumn::make('description')
                    ->formatStateUsing(
                        fn ($state) => strip_tags($state ?? '')
                    )
                    ->limit(40)
                    ->width('40%')
                    ->tooltip(
                        fn ($record) => strip_tags($record->description ?? '')
                    ),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
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
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}