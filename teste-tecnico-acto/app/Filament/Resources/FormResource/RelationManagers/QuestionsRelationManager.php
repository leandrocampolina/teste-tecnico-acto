<?php

namespace App\Filament\Resources\FormResource\RelationManagers;

use App\Filament\Resources\QuestionResource\RelationManagers\AlternativesRelationManager;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';
    protected static ?string $recordTitleAttribute = 'text';

    public function form(Forms\Form $form): Forms\Form
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

    public function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('text')->label('Texto')->wrap(),
            TextColumn::make('type')->label('Tipo'),
            TextColumn::make('is_required')->label('Obrigatória')->boolean(),
        ])->defaultSort('order');
    }

    public static function getRelationManagers(): array
    {
        return [
            AlternativesRelationManager::class,
        ];
    }
}
