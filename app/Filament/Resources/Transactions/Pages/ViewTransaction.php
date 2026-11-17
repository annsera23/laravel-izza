<?php

namespace App\Filament\Resources\Transactions\Pages;

use App\Filament\Resources\Transactions\TransactionResource;
use Filament\Actions\EditAction;
use Filament\Infolists\Components\Card;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewTransaction extends ViewRecord
{
    protected static string $resource = TransactionResource::class;

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                // General Information
                Card::make([
                    TextEntry::make('invoice')
                        ->label('Invoice'),

                    TextEntry::make('status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'pending' => 'warning',
                            'success' => 'success',
                            'expired' => 'gray',
                            'failed' => 'danger',
                        }),

                    TextEntry::make('created_at')
                        ->label('Created At'),
                ])
                ->columns(3),

                // Customer Information
                Card::make([
                    TextEntry::make('customer_name')
                        ->label('Customer Name'),

                    TextEntry::make('customer_email')
                        ->label('Email Address'),

                    TextEntry::make('address')
                        ->label('Address'),
                ])
                ->columns(3),

                // Ongkos Kirim
                Card::make([
                    TextEntry::make('shipping_shipping_courier')
                        ->label('Jasa Kirim'),

                    TextEntry::make('shipping_shipping_service')
                        ->label('Layanan Kirim'),

                    TextEntry::make('shipping_shipping_cost')
                        ->label('Biaya Kirim')
                        ->numeric()
                        ->money('IDR', locale: 'id'),
                ])
                ->columns(3),

                // Transaction Details
                Card::make([
                    RepeatableEntry::make('TransactionDetails')
                        ->label('Item Details')
                        ->schema([
                            ImageEntry::make('product_image')
                                ->label('Product Image')
                                ->circular()
                                ->width(100)
                                ->height(100),

                            TextEntry::make('product_title')
                                ->label('Product Name'),

                            TextEntry::make('qty')
                                ->label('Quantity'),

                            TextEntry::make('price')
                                ->label('Price')
                                ->money('IDR', locale: 'id'),
                        ])
                        ->columns(4),
                ]),

                Card::make([
                    // Row container grid untuk alignment
                    Grid::make(3)
                        ->schema([
                            TextEntry::make('total')
                                ->label('Grand Total')
                                ->numeric(decimalPlaces: 0)
                                ->prefix('IDR')
                                ->size('lg')
                                ->weight('bold')
                                ->alignEnd(),
                        ]),
                ]),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}