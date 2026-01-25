<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestResource\Pages;
use App\Models\Test;
use App\Models\Content;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

/**
 * TestResource - Testlar uchun admin panel resursi
 * Test savollari va javob variantlarini boshqarish
 */
class TestResource extends Resource
{
    protected static ?string $model = Test::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Testlar';

    protected static ?string $modelLabel = 'Test';

    protected static ?string $pluralModelLabel = 'Testlar';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Asosiy ma\'lumotlar')
                    ->schema([
                        Forms\Components\Select::make('content_id')
                            ->label('Material')
                            ->options(function () {
                                return Content::where('type', 'test')
                                    ->pluck('title_ru', 'id');
                            })
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText('Faqat "test" turidagi materiallar'),

                        Forms\Components\TextInput::make('title')
                            ->label('Test nomi')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->label('Test tavsifi')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Sozlamalar')
                    ->schema([
                        Forms\Components\TextInput::make('time_limit')
                            ->label('Vaqt chegarasi (daqiqalarda)')
                            ->numeric()
                            ->placeholder('10')
                            ->helperText('Bo\'sh qoldiring agar vaqt cheklanmagan bo\'lsa'),

                        Forms\Components\TextInput::make('attempts_allowed')
                            ->label('Ruxsat berilgan urinishlar')
                            ->numeric()
                            ->placeholder('3')
                            ->helperText('Bo\'sh qoldiring agar cheklanmagan bo\'lsa'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Faol')
                            ->default(true),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Savollar')
                    ->schema([
                        Forms\Components\Repeater::make('questions')
                            ->relationship()
                            ->schema([
                                Forms\Components\Textarea::make('question_text')
                                    ->label('Savol matni')
                                    ->required()
                                    ->rows(2)
                                    ->columnSpanFull(),

                                Forms\Components\FileUpload::make('image')
                                    ->label('Savol uchun rasm')
                                    ->image()
                                    ->directory('test-questions')
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('order')
                                    ->label('Tartib')
                                    ->numeric()
                                    ->default(0)
                                    ->columnSpan(1),

                                Forms\Components\Repeater::make('options')
                                    ->label('Javob variantlari')
                                    ->relationship()
                                    ->schema([
                                        Forms\Components\TextInput::make('option_text')
                                            ->label('Variant matni')
                                            ->required()
                                            ->columnSpan(3),

                                        Forms\Components\Toggle::make('is_correct')
                                            ->label('To\'g\'ri')
                                            ->columnSpan(1),

                                        Forms\Components\TextInput::make('order')
                                            ->label('Tartib')
                                            ->numeric()
                                            ->default(0)
                                            ->columnSpan(1),
                                    ])
                                    ->columns(5)
                                    ->minItems(2)
                                    ->maxItems(6)
                                    ->defaultItems(4)
                                    ->reorderable()
                                    ->collapsible()
                                    ->columnSpanFull(),
                            ])
                            ->minItems(1)
                            ->defaultItems(1)
                            ->reorderable()
                            ->collapsible()
                            ->cloneable()
                            ->columnSpanFull()
                            ->itemLabel(fn (array $state): ?string => $state['question_text'] ?? 'Yangi savol'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Test nomi')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('content.title_ru')
                    ->label('Material')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('questions_count')
                    ->label('Savollar')
                    ->counts('questions')
                    ->sortable(),

                Tables\Columns\TextColumn::make('time_limit')
                    ->label('Vaqt (daq.)')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('attempts_allowed')
                    ->label('Urinishlar')
                    ->placeholder('∞'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Faol')
                    ->boolean(),

                Tables\Columns\TextColumn::make('attempts_count')
                    ->label('Jami urinishlar')
                    ->counts('attempts')
                    ->sortable(),

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
            'index' => Pages\ListTests::route('/'),
            'create' => Pages\CreateTest::route('/create'),
            'edit' => Pages\EditTest::route('/{record}/edit'),
        ];
    }
}

