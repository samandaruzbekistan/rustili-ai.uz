<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SectionResource\Pages;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

/**
 * SectionResource - Bo'limlar uchun admin panel resursi
 */
class SectionResource extends Resource
{
    protected static ?string $model = Section::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';

    protected static ?string $navigationLabel = 'Bo\'limlar';

    protected static ?string $modelLabel = 'Bo\'lim';

    protected static ?string $pluralModelLabel = 'Bo\'limlar';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Asosiy ma\'lumotlar')
                    ->schema([
                        Forms\Components\Select::make('chapter_id')
                            ->label('Bob')
                            ->relationship('chapter', 'title_ru')
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('title_ru')
                            ->label('Nom (RU)')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, ?string $state) {
                                if ($state) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('title_uz')
                            ->label('Nom (UZ)')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\RichEditor::make('description')
                            ->label('Tavsif')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'heading',
                                'h1',
                                'h2',
                                'h3',
                                'orderedList',
                                'bulletList',
                                'blockquote',
                                'codeBlock',
                                'attachFiles',
                                'redo',
                                'undo',
                            ])
                            ->fileAttachmentsDirectory('sections/attachments')
                            ->fileAttachmentsVisibility('public')
                            ->columnSpanFull()
                            ->helperText('Emoji\'larni to\'g\'ridan-to\'g\'ri yozing yoki Telegramdan copy qiling. Rasm yuklash uchun attachFiles button\'ini bosing yoki clipboard\'dan paste qiling.'),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Ko\'rinish va turi')
                    ->schema([
                        Forms\Components\FileUpload::make('cover_image')
                            ->label('Muqova rasmi')
                            ->image()
                            ->directory('sections')
                            ->imageEditor(),

                        Forms\Components\Select::make('section_type')
                            ->label('Bo\'lim turi')
                            ->options([
                                'generic' => '📚 Umumiy',
                                'text' => '📖 Matn',
                                'audio' => '🎧 Audio',
                                'video' => '🎬 Video',
                                'file' => '📁 Fayl',
                                'test' => '📝 Test',
                                'mixed' => '🎨 Aralash',
                            ])
                            ->default('generic')
                            ->required(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Sozlamalar')
                    ->schema([
                        Forms\Components\TextInput::make('order')
                            ->label('Tartib raqami')
                            ->numeric()
                            ->default(0),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Faol')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Rasm')
                    ->circular(),

                Tables\Columns\TextColumn::make('chapter.title_ru')
                    ->label('Bob')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title_ru')
                    ->label('Nom (RU)')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title_uz')
                    ->label('Nom (UZ)')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('section_type')
                    ->label('Turi')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match($state) {
                        'generic' => '📚 Umumiy',
                        'text' => '📖 Matn',
                        'audio' => '🎧 Audio',
                        'video' => '🎬 Video',
                        'file' => '📁 Fayl',
                        'test' => '📝 Test',
                        'mixed' => '🎨 Aralash',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('contents_count')
                    ->label('Materiallar')
                    ->counts('contents')
                    ->sortable(),

                Tables\Columns\TextColumn::make('order')
                    ->label('Tartib')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Faol')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('chapter_id')
                    ->label('Bob')
                    ->relationship('chapter', 'title_ru'),

                Tables\Filters\SelectFilter::make('section_type')
                    ->label('Bo\'lim turi')
                    ->options([
                        'generic' => 'Umumiy',
                        'text' => 'Matn',
                        'audio' => 'Audio',
                        'video' => 'Video',
                        'file' => 'Fayl',
                        'test' => 'Test',
                        'mixed' => 'Aralash',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Faollik holati'),
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
            'index' => Pages\ListSections::route('/'),
            'create' => Pages\CreateSection::route('/create'),
            'edit' => Pages\EditSection::route('/{record}/edit'),
        ];
    }
}

