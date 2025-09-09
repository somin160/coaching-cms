<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Select::make('type')
                    ->label('Category Type')
                    ->options([
                        'Online'  => 'Online',
                        'Offline' => 'Offline',
                        'DLP'     => 'DLP',
                    ])
                    ->required()
                    ->reactive()            // 🔹 Make reactive for live updates
                    ->default(fn () => null), // 🔹 No default, admin chooses

                Select::make('parent_id')
                    ->label('Parent Category')
                    ->relationship('parent', 'name', function ($query, $get) {
                        $type = $get('type');
                        return $type ? $query->where('type', $type) : $query;
                    })
                    ->searchable()
                    ->nullable(),

                Toggle::make('status')
                    ->label('Active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('slug')->searchable(),
                TextColumn::make('type')->sortable(),
                TextColumn::make('parent.name')->label('Parent Category'),
                IconColumn::make('status')->boolean()->label('Active'),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'Online'  => 'Online',
                        'Offline' => 'Offline',
                        'DLP'     => 'DLP',
                    ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit'   => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
