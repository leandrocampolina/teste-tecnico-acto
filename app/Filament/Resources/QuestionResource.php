<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionResource\Pages;
use App\Filament\Resources\QuestionResource\RelationManagers\AlternativesRelationManager;
use App\Models\Question;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;
    protected static ?string $navigationLabel = 'Perguntas';
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('text')->label('Pergunta')->required()->maxLength(1000),
            Select::make('type')
                ->label('Tipo')
                ->options([
                    'multiple_choice' => 'Múltipla Escolha',
                    'text' => 'Texto',
                ])
                ->required(),
            Toggle::make('is_required')->label('Obrigatória')->default(true),
            TextInput::make('order')->label('Ordem')->numeric()->default(0),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('text')->label('Texto')->wrap(),
            TextColumn::make('type')->label('Tipo'),
            TextColumn::make('is_required')->label('Obrigatória')->boolean(),
        ])->defaultSort('order');
    }

    public static function getRelations(): array
    {
        return [
            AlternativesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
