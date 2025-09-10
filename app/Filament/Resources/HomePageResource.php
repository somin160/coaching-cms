<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomePageResource\Pages;
use App\Models\HomePage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class HomePageResource extends Resource
{
    protected static ?string $model = HomePage::class;
    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationLabel = 'Home Page';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Page Details')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Tabs::make('Home Page Sections')->tabs([

                    // TAB 1: HERO SLIDER (with Toggle)
                    Forms\Components\Tabs\Tab::make('Hero Slider')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            Forms\Components\Repeater::make('hero_slider')
                                ->label('Slider Items')
                                ->schema([
                                    Forms\Components\FileUpload::make('image')->label('Slide Image')
                                        ->image()->directory('hero-slider')->required(),
                                    Forms\Components\TextInput::make('title')->label('Main Heading')->required(),
                                    Forms\Components\Textarea::make('subtitle')->label('Sub-heading')->rows(2),

                                    // Toggle to decide where to show the slide
                                    Forms\Components\Toggle::make('is_main_banner')
                                        ->label('Show in Main Banner?')
                                        ->helperText('ON = Top hero banner, OFF = Achievers section below')
                                        ->default(false)
                                        ->columnSpanFull(),
                                ])
                                ->columns(2)
                                ->addActionLabel('Add New Slide'),
                        ]),

                    // TAB 2: WHY US SECTION (Image with Content)
                    Forms\Components\Tabs\Tab::make('Why Us Section')
                        ->icon('heroicon-o-sparkles')
                        ->schema([
                            Forms\Components\FileUpload::make('why_us_image')->label('Main Image')
                                ->image()->directory('why-us'),
                            Forms\Components\TextInput::make('why_us_title')->label('Section Title')->default('Why Career Point?'),
                            Forms\Components\Repeater::make('why_us_points')
                                ->label('Points')
                                ->schema([
                                    Forms\Components\TextInput::make('point')->required(),
                                ])
                                ->addActionLabel('Add Point'),
                        ]),

                    // TAB 3: IMAGE GALLERY
                    Forms\Components\Tabs\Tab::make('Image Gallery')
                        ->icon('heroicon-o-squares-2x2')
                        ->schema([
                             Forms\Components\Repeater::make('image_grid')
                                ->label('Gallery Images')
                                ->schema([
                                    Forms\Components\FileUpload::make('image')->label('Image')
                                        ->image()->directory('image-grid')->required(),
                                    Forms\Components\TextInput::make('caption')->label('Caption (Optional)'),
                                ])
                                ->addActionLabel('Add Image to Gallery'),
                        ]),

                    // TAB 4: VIDEOS
                    Forms\Components\Tabs\Tab::make('Videos')
                        ->icon('heroicon-o-video-camera')
                        ->schema([
                            Forms\Components\Repeater::make('videos')
                                ->schema([
                                    Forms\Components\FileUpload::make('thumbnail')->label('Video Thumbnail')
                                        ->image()->directory('video-thumbnails')->required(),
                                    Forms\Components\TextInput::make('video_url')->label('YouTube/Vimeo URL')
                                        ->url()->required(),
                                    Forms\Components\TextInput::make('title')->label('Video Title'),
                                ])
                                ->addActionLabel('Add Video'),
                        ]),

                    // TAB 5: TESTIMONIALS
                    Forms\Components\Tabs\Tab::make('Testimonials')
                        ->icon('heroicon-o-chat-bubble-left-right')
                        ->schema([
                            Forms\Components\Repeater::make('testimonials')
                                ->schema([
                                    Forms\Components\FileUpload::make('avatar')->image()->directory('testimonials')->required(),
                                    Forms\Components\TextInput::make('name')->required(),
                                    Forms\Components\TextInput::make('designation')->required(),
                                    Forms\Components\Textarea::make('quote')->required()->rows(4)->columnSpanFull(),
                                ])
                                ->columns(2)
                                ->addActionLabel('Add Testimonial'),
                        ]),

                    // TAB 6: FAQS
                    Forms\Components\Tabs\Tab::make('FAQs')
                        ->icon('heroicon-o-question-mark-circle')
                        ->schema([
                            Forms\Components\Repeater::make('faqs')
                                ->schema([
                                    Forms\Components\TextInput::make('question')->required()->columnSpanFull(),
                                    Forms\Components\RichEditor::make('answer')->required()->columnSpanFull(),
                                ])
                                ->addActionLabel('Add FAQ'),
                        ]),

                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->weight('bold'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime('d M, Y')->sortable(),
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomePages::route('/'),
            'create' => Pages\CreateHomePage::route('/create'),
            'edit' => Pages\EditHomePage::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        // This ensures only one home page can be created
        return !HomePage::exists();
    }
}
