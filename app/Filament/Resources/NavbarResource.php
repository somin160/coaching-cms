<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NavbarResource\Pages;
use App\Models\Navbar;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Str;


class NavbarResource extends Resource
{
    protected static ?string $model = Navbar::class;
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                      ->label('Slug')
                      ->maxLength(255)
                      ->unique(ignoreRecord: true)
                      ->placeholder('Auto-generated from title')
                      ->reactive()
                      ->afterStateUpdated(function (callable $set, $state) {
                          if (empty($state)) {
                              $set('slug', Str::slug($state)); // fallback
                          }
                       }),


                Select::make('parent_id')
                    ->label('Parent Menu')
                    ->relationship('parent', 'title')
                    ->nullable()
                    ->searchable()
                    ->helperText('Select parent for dropdown, leave empty for top-level'),

                TextInput::make('order')
                    ->label('Order')
                    ->numeric()
                    ->default(0),

                Toggle::make('status')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('title')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('slug')->sortable(),
                Tables\Columns\TextColumn::make('parent.title')->label('Parent Menu'),
                Tables\Columns\TextColumn::make('order')->sortable(),
                Tables\Columns\IconColumn::make('status')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->defaultSort('order');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListNavbars::route('/'),
            'create' => Pages\CreateNavbar::route('/create'),
            'edit'   => Pages\EditNavbar::route('/{record}/edit'),
        ];
    }
}
