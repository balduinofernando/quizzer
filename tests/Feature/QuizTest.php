<?php

use App\Models\Quiz;
use App\Models\User;
use App\Filament\Resources\QuizResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Livewire\livewire;

uses(RefreshDatabase::class);

describe("Quiz tests", function () {
    test("can render quiz index page", function () {
        $quizzes = Quiz::factory()->count(10)->create();

        livewire(QuizResource\Pages\ListQuizzes::class)
            ->assertCanSeeTableRecords($quizzes);
    });

    test("can render quiz creation page", function () {
        $this->get(QuizResource::getUrl("create"))
            ->assertSuccessful();
    });
});
