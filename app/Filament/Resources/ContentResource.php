<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContentResource\Pages;
use App\Models\Content;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * ContentResource - Materiallar uchun admin panel resursi
 */
class ContentResource extends Resource
{
    protected static ?string $model = Content::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Materiallar';

    protected static ?string $modelLabel = 'Material';

    protected static ?string $pluralModelLabel = 'Materiallar';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Bog\'lanishlar')
                    ->schema([
                        Forms\Components\Select::make('chapter_id')
                            ->label('Bob')
                            ->relationship('chapter', 'title_ru')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(fn (Forms\Set $set) => $set('section_id', null)),

                        Forms\Components\Select::make('section_id')
                            ->label('Bo\'lim (ixtiyoriy)')
                            ->options(function (Forms\Get $get) {
                                $chapterId = $get('chapter_id');
                                if (!$chapterId) {
                                    return [];
                                }
                                return Section::where('chapter_id', $chapterId)
                                    ->where('is_active', true)
                                    ->pluck('title_ru', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->placeholder('Bo\'limsiz (to\'g\'ridan-to\'g\'ri bobga)'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Asosiy ma\'lumotlar')
                    ->schema([
                        Forms\Components\TextInput::make('title_ru')
                            ->label('Nom (RU)')
                            ->required()
                            ->maxLength(255)
                            ->helperText(fn (Forms\Get $get): string => $get('type') === 'riddle' ? 'Savol matni (rus tilida)' : 'Material nomi (rus tilida)'),

                        Forms\Components\TextInput::make('title_uz')
                            ->label('Nom (UZ)')
                            ->maxLength(255)
                            ->helperText(fn (Forms\Get $get): string => $get('type') === 'riddle' ? 'Savol matni (o\'zbek tilida)' : 'Material nomi (o\'zbek tilida)'),

                        Forms\Components\Select::make('type')
                            ->label('Material turi')
                            ->options([
                                'text' => '📖 Matn',
                                'audio' => '🎧 Audio',
                                'video' => '🎬 Video',
                                'file' => '📁 Fayl',
                                'test' => '📝 Test',
                                'image' => '🖼️ Rasm',
                                'mixed' => '🎨 Aralash',
                                'riddle' => '❓ Topishmoq',
                            ])
                            ->default('text')
                            ->required()
                            ->live(),

                        Forms\Components\FileUpload::make('cover_image')
                            ->label('Muqova rasmi')
                            ->image()
                            ->directory('contents')
                            ->imageEditor()
                            ->helperText('JPG, PNG, GIF, WEBP formatlaridagi rasmlar'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Yosh chegaralari')
                    ->schema([
                        Forms\Components\TextInput::make('age_from')
                            ->label('Minimal yosh')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(18)
                            ->placeholder('3'),

                        Forms\Components\TextInput::make('age_to')
                            ->label('Maksimal yosh')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(18)
                            ->placeholder('10'),
                    ])
                    ->columns(2),

                // Matn kontent (type = text, mixed, image)
                Forms\Components\Section::make('Matn kontenti')
                    ->schema([
                        Forms\Components\RichEditor::make('body_ru')
                            ->label('Matn (RU)')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'orderedList',
                                'bulletList',
                                'h2',
                                'h3',
                                'blockquote',
                                'redo',
                                'undo',
                            ])
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('body_uz')
                            ->label('Matn (UZ)')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'orderedList',
                                'bulletList',
                                'h2',
                                'h3',
                                'blockquote',
                                'redo',
                                'undo',
                            ])
                            ->columnSpanFull(),
                    ])
                    ->visible(fn (Forms\Get $get): bool => in_array($get('type'), ['text', 'mixed', 'image'])),

                // Topishmoq kontent (type = riddle)
                Forms\Components\Section::make('Topishmoq')
                    ->schema([
                        Forms\Components\Placeholder::make('riddle_note')
                            ->label('')
                            ->content('💡 Eslatma: "Nom (RU)" va "Nom (UZ)" maydonlari savol matni sifatida ishlatiladi.')
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('body_ru')
                            ->label('Javob (RU)')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'orderedList',
                                'bulletList',
                                'h2',
                                'h3',
                                'blockquote',
                                'redo',
                                'undo',
                            ])
                            ->columnSpanFull()
                            ->helperText('Topishmoq javobi (rus tilida)'),

                        Forms\Components\RichEditor::make('body_uz')
                            ->label('Javob (UZ)')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'orderedList',
                                'bulletList',
                                'h2',
                                'h3',
                                'blockquote',
                                'redo',
                                'undo',
                            ])
                            ->columnSpanFull()
                            ->helperText('Topishmoq javobi (o\'zbek tilida)'),
                    ])
                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'riddle'),

                // Audio kontent (type = audio, mixed)
                Forms\Components\Section::make('Audio')
                    ->schema([
                        Forms\Components\TextInput::make('audio_url')
                            ->label('Audio fayl manzili')
                            ->url()
                            ->placeholder('https://example.com/audio.mp3')
                            ->helperText('Audio faylga to\'liq URL yoki FileUpload orqali yuklang'),
                    ])
                    ->visible(fn (Forms\Get $get): bool => in_array($get('type'), ['audio', 'mixed'])),

                // Video kontent (type = video, mixed)
                Forms\Components\Section::make('Video')
                    ->schema([
                        Forms\Components\Textarea::make('video_url')
                            ->label('Video iframe kodi')
                            ->placeholder('<iframe width="560" height="315" src="https://www.youtube.com/embed/VIDEO_ID" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>')
                            ->rows(3)
                            ->helperText('YouTube yoki boshqa platformadan iframe HTML kodini copy qilib qo\'ying')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn (Forms\Get $get): bool => in_array($get('type'), ['video', 'mixed'])),

                // Fayl kontent (type = file, mixed)
                Forms\Components\Section::make('Fayl')
                    ->schema([
                        Forms\Components\FileUpload::make('file_url')
                            ->label('Yuklab olinadigan fayl')
                            ->directory('files')
                            ->acceptedFileTypes([
                                'application/pdf',
                                'application/msword',
                                'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                'application/vnd.ms-powerpoint',
                                'application/vnd.openxmlformats-officedocument.presentationml.presentation'
                            ])
                            ->helperText('PDF, DOC, DOCX, PPT, PPTX formatlaridagi fayllar'),
                    ])
                    ->visible(fn (Forms\Get $get): bool => in_array($get('type'), ['file', 'mixed'])),

                // Test uchun eslatma
                Forms\Components\Section::make('Test')
                    ->schema([
                        Forms\Components\Placeholder::make('test_note')
                            ->label('')
                            ->content('Materialni saqlagandan so\'ng, Testlar bo\'limida test savollarini qo\'shing.')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn (Forms\Get $get): bool => $get('type') === 'test'),

                Forms\Components\Section::make('Nashr sozlamalari')
                    ->schema([
                        Forms\Components\Toggle::make('is_published')
                            ->label('Chop etilgan')
                            ->default(true),

                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Nashr sanasi'),

                        Forms\Components\TextInput::make('order')
                            ->label('Tartib raqami')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Rasm')
                    ->circular(),

                Tables\Columns\TextColumn::make('title_ru')
                    ->label('Nom (RU)')
                    ->searchable()
                    ->sortable()
                    ->limit(40),

                Tables\Columns\TextColumn::make('chapter.title_ru')
                    ->label('Bob')
                    ->searchable()
                    ->sortable()
                    ->limit(20),

                Tables\Columns\TextColumn::make('section.title_ru')
                    ->label('Bo\'lim')
                    ->searchable()
                    ->placeholder('-')
                    ->limit(20),

                Tables\Columns\TextColumn::make('type')
                    ->label('Turi')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'text' => '📖 Matn',
                        'audio' => '🎧 Audio',
                        'video' => '🎬 Video',
                        'file' => '📁 Fayl',
                        'test' => '📝 Test',
                        'image' => '🖼️ Rasm',
                        'mixed' => '🎨 Aralash',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('age_range')
                    ->label('Yosh')
                    ->getStateUsing(function (Content $record): ?string {
                        return $record->age_range;
                    }),

                Tables\Columns\TextColumn::make('order')
                    ->label('Tartib')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Chop etilgan')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Yaratilgan')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('chapter_id')
                    ->label('Bob')
                    ->relationship('chapter', 'title_ru'),

                Tables\Filters\SelectFilter::make('section_id')
                    ->label('Bo\'lim')
                    ->relationship('section', 'title_ru'),

                Tables\Filters\SelectFilter::make('type')
                    ->label('Material turi')
                    ->options([
                        'text' => 'Matn',
                        'audio' => 'Audio',
                        'video' => 'Video',
                        'file' => 'Fayl',
                        'test' => 'Test',
                        'image' => 'Rasm',
                        'mixed' => 'Aralash',
                    ]),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Chop etilgan'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order');
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
            'index' => Pages\ListContents::route('/'),
            'create' => Pages\CreateContent::route('/create'),
            'edit' => Pages\EditContent::route('/{record}/edit'),
        ];
    }
}

