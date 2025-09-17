<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Forms\Components\Ckeditor;
use App\Models\Page;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Support\Str;
use Filament\Forms\Components\Field;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                // The layout is the same single column you wanted.
                Select::make('page_type')
                    ->options([
                        'Custom'   => 'Custom',
                        'Category' => 'Category',
                        'Course'   => 'Course',
                    ])
                    ->required()
                    ->reactive(),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->disabled()
                    ->dehydrated(),

                Select::make('category_id')
                    ->label('Category')
                    ->options(function () {
                        // This logic already correctly shows the parent category.
                        return Category::with('parent')->get()->mapWithKeys(function ($category) {
                            $label = $category->parent
                                ? $category->parent->name . ' -> ' . $category->name
                                : $category->name;

                            return [$category->id => strtoupper($category->type) . ' - ' . $label];
                        });
                    })
                    ->searchable()
                    ->required(fn (callable $get) => $get('page_type') === 'Category')
                    ->visible(fn ($get) => $get('page_type') === 'Category'),

                Toggle::make('status')
                    ->label('Visible')
                    ->default(true),

                Repeater::make('sections')
                    ->label('Page Sections')
                    ->collapsible()
                    ->columnSpanFull()
                    ->schema([
                        Select::make('section_type')
                            ->options([
                                'HeroSection'      => 'Hero Section',
                                'TextWithImages'   => 'Text / Image Grid',
                                'Carousel'         => 'Carousel',
                                'FAQs'             => 'FAQs',
                                'TextEditor'       => 'Text Editor',
                            ])
                            ->required()
                            ->reactive(),

                        Fieldset::make('Section Data')
                            ->schema(fn (callable $get) => match ($get('section_type')) {
                                'HeroSection' => [
                                    TextInput::make('title')->required(),
                                    TextInput::make('subtitle'),
                                    FileUpload::make('background_image')->image()->disk('public'),
                                ],
                                'TextWithImages' => [
                                    Repeater::make('items')->schema([
                                        TextInput::make('title'),
                                        Textarea::make('description'),
                                        FileUpload::make('image')->image()->disk('public'),
                                    ]),
                                ],
                                'Carousel' => [
                                    Repeater::make('slides')->schema([
                                        FileUpload::make('image')->image()->required()->disk('public'),
                                        TextInput::make('caption'),
                                    ]),
                                ],
                                'FAQs' => [
                                    Repeater::make('items')->schema([
                                        TextInput::make('question')->required(),
                                        Textarea::make('answer')->required(),
                                    ]),
                                ],
                                'TextEditor' => [
                                    // THIS IS THE NEW, BETTER EDITOR
                                    Ckeditor::make('content')
                                        ->required()
                                        ->columnSpanFull(),
                                ],
                                default => [],
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            Tables\Columns\TextColumn::make('id')->sortable(),
            Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
            Tables\Columns\TextColumn::make('page_type'),
            Tables\Columns\TextColumn::make('category.type')->label('Main Category'),
            Tables\Columns\TextColumn::make('category.name')->label('Sub Category'),
            Tables\Columns\IconColumn::make('status')->boolean(),
            Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
}


    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit'   => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
