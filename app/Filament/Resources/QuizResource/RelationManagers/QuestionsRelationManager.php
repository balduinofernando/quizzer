<?php

namespace App\Filament\Resources\QuizResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

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
                TextInput::make('title')
                    ->required()
                    ->label('Pergunta'),
                TextInput::make('description')
                    ->label('Descrição'),
                TextInput::make('explanation')
                    ->label('Explicação'),
                TextInput::make('score')
                    ->integer()
                    ->label('Pontuação'),

                Repeater::make('options')
                    ->addable()
                    ->addActionLabel('Adicionar Opção')
                    ->relationship('options')
                    ->label('Opções')
                    ->cloneable(true)
                    ->minItems(1)
                    ->grid(2)
                    ->columnSpanFull()
                    ->deleteAction(
                        fn (Action $action) => $action->requiresConfirmation()
                            ->modalHeading('Excluir Opção')
                            ->modalDescription('Você tem certeza disso?')
                            ->modalCancelActionLabel('Cancelar')
                            ->modalSubmitActionLabel('Excluir')
                    )
                    ->schema([
                        TextInput::make('description')
                        ->label('Opção'),
                        Checkbox::make('is_correct')
                            ->distinct()
                        //Radio::make('is_correct')
                            // ->default(false)
                            // ->options([
                            //     true => 'Não',
                            //     false => 'Sim',
                            // ])
                            ->label('Resposta Correta?'),
                    ])
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
                Tables\Actions\ViewAction::make()
                    //->view('filament.resources.questions.view')
                    ->label('Ver Pergunta'),
                Tables\Actions\EditAction::make()->label('Editar Pergunta'),
                Tables\Actions\DeleteAction::make()->label('Excluir Pergunta')
                    ->requiresConfirmation(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
