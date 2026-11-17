<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columnSpanFull()
                    ->schema([
                        // Image
                        FileUpload::make('image')
                            ->label('Category Image')
                            ->placeholder('Category Image')
                            ->disk('public')
                            ->directory('categories')
                            ->required(),

                        // name
                        TextInput::make('name')
                            ->label('Category Name')
                            ->placeholder('Category Name')
                            ->required(),
                    ]),
            ]);
    }
}