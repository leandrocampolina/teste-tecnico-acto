<?php

namespace App\Filament\Resources;

use App\Models\FormResponse;
use Filament\Resources\Resource;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\KeyValue;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;

class FormResponseResource extends Resource
{
    protected static ?string $model = FormResponse::class;
    protected static ?string $navigationLabel = 'Respostas';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-list';

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('form.title')->label('Formulário')->wrap()->sortable(),
            TextColumn::make('user.email')->label('Respondido por'),
            TextColumn::make('created_at')->label('Respondido em')->dateTime(),
        ])->actions([
            Action::make('view')->label('Ver')->url(fn (FormResponse $record): string => route('filament.resources.form-responses.view', $record)),
        ])->defaultSort('created_at', 'desc');
    }

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Card::make()->schema([
                TextColumn::make('form.title')->label('Título do formulário'),
                TextColumn::make('user.email')->label('Usuário'),
                KeyValue::make('snapshot')->label('Snapshot')->disabled(),
            ]),
        ]);
    }
}
