<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FormResponseResource\Pages;
use App\Filament\Resources\FormResource\RelationManagers\QuestionsRelationManager;
use App\Models\Form;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class FormResource extends Resource
{
    protected static ?string $model = Form::class;
    protected static ?string $navigationLabel = 'Formulários';
    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('title')->label('Título')->required()->maxLength(255),
            Textarea::make('description')->label('Descrição')->rows(3),
            Toggle::make('is_active')->label('Ativo')->default(true),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('title')->label('Título')->sortable()->searchable()->wrap(),
            TextColumn::make('is_active')->label('Ativo')->boolean(),
            TextColumn::make('created_at')->label('Criado em')->dateTime(),
        ])->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFormResponses::route('/'),
            'view' => Pages\ViewFormResponse::route('/{record}'),
        ];
    }
}
