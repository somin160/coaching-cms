<?php

namespace App\Filament\Resources;

use App\Models\HomePage;
use Filament\Resources\Resource;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class HomePageResource extends Resource
{
    protected static ?string $model = HomePage::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    // ====================
    // Form Definition
    // ====================
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Hero Banner Section
                Repeater::make('hero_banners')
                    ->label('Hero Banners')
                    ->schema([
                        TextInput::make('title')->required(),
                        Textarea::make('subtitle'),
                        FileUpload::make('image')->image()->required(),
                        TextInput::make('button_text'),
                        TextInput::make('button_url'),
                    ])
                    ->columns(1)
                    ->collapsible(),

                // Courses Section
                Repeater::make('courses')
                    ->label('Courses by Category')
                    ->relationship('categories')
                    ->schema([
                        TextInput::make('name')->required(),
                        Textarea::make('description'),
                        FileUpload::make('image')->image(),
                        TextInput::make('button_text'),
                        TextInput::make('button_url'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                // Rankers Section
                Repeater::make('rankers')
                    ->label('Rankers')
                    ->schema([
                        TextInput::make('name')->required(),
                        Textarea::make('description'),
                        FileUpload::make('image')->image(),
                    ])
                    ->columns(2)
                    ->collapsible(),

                // Image + Content Section
                Repeater::make('image_content_sections')
                    ->label('Image + Content Sections')
                    ->schema([
                        FileUpload::make('image')->image()->required(),
                        TextInput::make('title')->required(),
                        Textarea::make('content'),
                    ])
                    ->columns(2)
                    ->collapsible(),

                // Video Slider Section
                Repeater::make('videos')
                    ->label('Video Slider')
                    ->schema([
                        TextInput::make('title')->required(),
                        TextInput::make('video_url')->required(),
                    ])
                    ->columns(1)
                    ->collapsible(),

                // Image Grid Section
                Repeater::make('image_grid')
                    ->label('Image Grid')
                    ->schema([
                        FileUpload::make('image')->image()->required(),
                        TextInput::make('title'),
                    ])
                    ->columns(3)
                    ->collapsible(),

                // Achievers Section
                Repeater::make('achievers')
                    ->label('Achievers')
                    ->schema([
                        FileUpload::make('image')->image()->required(),
                        TextInput::make('name')->required(),
                        TextInput::make('description'),
                    ])
                    ->columns(3)
                    ->collapsible(),

                // Testimonials
                Repeater::make('testimonials')
                    ->label('Testimonials')
                    ->schema([
                        TextInput::make('name')->required(),
                        Textarea::make('feedback')->required(),
                        FileUpload::make('image')->image(),
                    ])
                    ->columns(1)
                    ->collapsible(),

                // FAQs
                Repeater::make('faqs')
                    ->label('FAQs')
                    ->schema([
                        TextInput::make('question')->required(),
                        Textarea::make('answer')->required(),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    // ====================
    // Table Definition
    // ====================
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('created_at')->dateTime(),
                TextColumn::make('updated_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    // ====================
    // Pages
    // ====================
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomePages::route('/'),
            'create' => Pages\CreateHomePage::route('/create'),
            'edit' => Pages\EditHomePage::route('/{record}/edit'),
        ];
    }
}
