<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
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
use Filament\Forms\Components\RichEditor;


class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

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
                    ->maxLength(255),

                TextInput::make('slug')
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->placeholder('Leave empty to auto-generate'),

                Select::make('category_id')
                    ->label('Category')
                    ->options(function () {
                        return Category::with('parent')->get()->mapWithKeys(function ($category) {
                            $label = $category->parent
                                ? $category->parent->name . ' -> ' . $category->name
                                : $category->name;

                            return [$category->id => strtoupper($category->type) . ' - ' . $label];
                        });
                    })
                    ->searchable()
                    ->required(fn (callable $get) => $get('page_type') === 'Category')
                    ->visible(fn ($get) => $get('page_type') === 'Category')
                    ->default(fn ($record) => $record?->category_id ?? null)
                    ->reactive(),

                Repeater::make('sections')
                    ->label('Page Sections')
                    ->schema([
                        Select::make('section_type')
                            ->options([
                                'HeroSection'      => 'Hero Section',
                                'TextWithImages'   => 'Text / Image Grid', // Combined
                                'Carousel'         => 'Carousel',
                                'FAQs'             => 'FAQs',
                                'TextEditor'       => 'Text Editor',
                            ])
                            ->required()
                            ->reactive(),

                        Fieldset::make('Section Data')
                            ->schema(function (callable $get) {
                                return match ($get('section_type')) {
                                    'HeroSection' => [
                                        TextInput::make('title')->required(),
                                        TextInput::make('subtitle'),
                                        FileUpload::make('background_image')->image(),
                                    ],
                                    'TextWithImages' => [
                                        Repeater::make('items')->schema([
                                            TextInput::make('title'),
                                            Textarea::make('description'),
                                            FileUpload::make('image')->image(),
                                        ]),
                                    ],
                                    'Carousel' => [
                                        Repeater::make('slides')->schema([
                                            FileUpload::make('image')->image()->required(),
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
                                       RichEditor::make('content')
                                        ->label('Page Content')
                                        ->columnSpanFull()
                                        ->fileAttachmentsDirectory('pages/content')
                                        ->toolbarButtons([
                                            'bold', 'italic', 'strike', 'link',
                                            'bulletList', 'orderedList', 'blockquote', 'codeBlock', 'image', 'historyUndo', 'historyRedo',
                                        ]),
                                    ],
                                    default => [],
                                };
                            }),
                    ])
                    ->default(fn ($record) => $record?->sections ?? [])
                    ->orderable()
                    ->collapsible()
                    ->columnSpanFull(),

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
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
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
