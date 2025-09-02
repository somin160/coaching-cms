<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Fieldset;

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
                        'Custom' => 'Custom',
                        'Category' => 'Category',
                        'Course' => 'Course',
                    ])
                    ->required(),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->nullable(),

                TextInput::make('meta_title')->maxLength(255),
                Textarea::make('meta_description')->rows(3)->maxLength(500),

                Toggle::make('status')->label('Active')->default(true),


                Repeater::make('sections')
                    ->label('Page Sections')
                    ->schema([
                        Select::make('section_type')
                            ->options([
                                'HeroSection' => 'Hero Section',
                                'TextWithImageGrid' => 'Text with Image Grid',
                                'ImageGrid' => 'Image Grid',
                                'Carousel' => 'Carousel',
                                'FAQs' => 'FAQs',
                                'TextEditor' => 'Text Editor',
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
                                    'FAQs' => [
                                        Repeater::make('items')->schema([
                                            TextInput::make('question')->required(),
                                            Textarea::make('answer')->required(),
                                        ]),
                                    ],
                                    'Carousel' => [
                                        Repeater::make('slides')->schema([
                                            FileUpload::make('image')->image()->required(),
                                            TextInput::make('caption'),
                                        ]),
                                    ],
                                    'TextWithImageGrid' => [
                                        Repeater::make('items')->schema([
                                            TextInput::make('title')->required(),
                                            Textarea::make('description'),
                                            FileUpload::make('image')->image(),
                                        ]),
                                    ],
                                    'ImageGrid' => [
                                        Repeater::make('images')->schema([
                                            FileUpload::make('image')->image()->required(),
                                        ]),
                                    ],
                                    'TextEditor' => [
                                        RichEditor::make('content')->required()
                                        ->columnSpanFull()
                                    ],
                                    default => [
                                        KeyValue::make('custom_data')->label('Custom Data (JSON)'),
                                    ],
                                };
                            }),
                    ])
                    ->default([])
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
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('category.name')->label('Category'),
                Tables\Columns\IconColumn::make('status')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
