<?php

namespace App\Filament\Resources\QuestionResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class AlternativesRelationManager extends RelationManager
{
    protected static string $relationship = 'alternatives';
    protected static ?string $recordTitleAttribute = 'text';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('text')->label('Alternativa')->required()->maxLength(1000),
            Toggle::make('is_correct')->label('Correta')->default(false),
            TextInput::make('order')->label('Ordem')->numeric()->default(0),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('text')->label('Texto')->wrap(),
            TextColumn::make('is_correct')->label('Correta')->boolean(),
        ])->defaultSort('order');
    }
}
