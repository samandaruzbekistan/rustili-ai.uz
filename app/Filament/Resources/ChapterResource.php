<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChapterResource\Pages;
use App\Models\Chapter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

/**
 * ChapterResource - Boblar uchun admin panel resursi
 */
class ChapterResource extends Resource
{
    protected static ?string $model = Chapter::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

    protected static ?string $navigationLabel = 'Boblar';

    protected static ?string $modelLabel = 'Bob';

    protected static ?string $pluralModelLabel = 'Boblar';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Asosiy ma\'lumotlar')
                    ->schema([
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

                        Forms\Components\Textarea::make('description')
                            ->label('Tavsif')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Ko\'rinish')
                    ->schema([
                        Forms\Components\TextInput::make('icon')
                            ->label('Ikon (emoji yoki class)')
                            ->placeholder('📚')
                            ->maxLength(50),

                        Forms\Components\FileUpload::make('cover_image')
                            ->label('Muqova rasmi')
                            ->image()
                            ->directory('chapters')
                            ->imageEditor()
                            ->columnSpanFull(),

                        Forms\Components\Select::make('default_content_type')
                            ->label('Default kontent turi')
                            ->options([
                                'text' => 'Matn',
                                'audio' => 'Audio',
                                'video' => 'Video',
                                'file' => 'Fayl',
                                'test' => 'Test',
                                'image' => 'Rasm',
                                'mixed' => 'Aralash',
                            ]),
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
                Tables\Columns\TextColumn::make('icon')
                    ->label('Ikon')
                    ->searchable(),

                Tables\Columns\ImageColumn::make('cover_image')
                    ->label('Rasm')
                    ->circular(),

                Tables\Columns\TextColumn::make('title_ru')
                    ->label('Nom (RU)')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title_uz')
                    ->label('Nom (UZ)')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('sections_count')
                    ->label('Bo\'limlar')
                    ->counts('sections')
                    ->sortable(),

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

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Yaratilgan')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
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
            'index' => Pages\ListChapters::route('/'),
            'create' => Pages\CreateChapter::route('/create'),
            'edit' => Pages\EditChapter::route('/{record}/edit'),
        ];
    }
}

