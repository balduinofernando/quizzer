<?php

namespace App\Filament\Resources\QuizResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questions';
    protected static ?string $title = 'Perguntas';

    function isReadOnly(): bool
    {
        return false;
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('quiz_id')
                    ->default($this->getOwnerRecord()->id)
                    ->required()
                    ->disabled()
                    ->maxLength(255),
                TextInput::make('title')
                    ->label('Pergunta'),
                TextInput::make('description')
                    ->label('Descrição'),
                TextInput::make('explanation')
                    ->label('Explicação'),
                TextInput::make('score')
                    ->label('Pontuação'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('quiz_id')
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Pergunta'),
                Tables\Columns\TextColumn::make('description')->label('Descrição'),
                Tables\Columns\TextColumn::make('explanation')->label('Explicação'),
                Tables\Columns\TextColumn::make('score')->label('Pontuação'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                // ->mutateFormDataUsing(function (array $data): array {
                //     dd($this->getOwnerRecord()->id);
                //     return [
                //         'quiz_id' => $this->getOwnerRecord()->id,
                //     ];
                // })
                    ->label('Adicionar Pergunta'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
