<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Filament\Resources\PageResource;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('parent_id')
                    ->label('Parent Category')
                    ->options(Category::whereNull('parent_id')->pluck('name', 'id'))
                    ->searchable(),
                Select::make('type')
                    ->options([
                        'online' => 'Online',
                        'offline' => 'Offline',
                    ])
                    ->required(),
                Toggle::make('status')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            // THIS IS THE NEW CUSTOM COLUMN
            Tables\Columns\TextColumn::make('name')
                ->label('Category Details')
                ->formatStateUsing(function ($state, Category $record) {
                    $type = strtoupper($record->type);
                    $parentName = $record->parent?->name;

                    if ($parentName) {
                        return "{$type} -> {$parentName} -> {$record->name}";
                    }

                    return "{$type} -> {$record->name}";
                })
                ->searchable(['name', 'type', 'parent.name'])
                ->sortable(),

            // Status column remains separate
            Tables\Columns\IconColumn::make('status')
                ->boolean(),
        ])
        ->filters([
            // ... your filters
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Action::make('edit_page')
                ->label('Edit Page')
                ->url(fn (Category $record): ?string => $record->page ? PageResource::getUrl('edit', ['record' => $record->page]) : null)
                ->openUrlInNewTab()
                ->icon('heroicon-o-pencil-square')
                ->hidden(fn (Category $record) => $record->page === null),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
