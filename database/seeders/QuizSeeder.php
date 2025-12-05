<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        // Basic Vocabulary Quiz
        $quiz1 = Quiz::create([
            'title' => 'Basic English Vocabulary Test',
            'description' => 'Test your knowledge of basic English words and phrases',
            'category_id' => 1,
            'type' => 'multiple_choice',
            'time_limit' => 10,
        ]);

        $questions1 = [
            [
                'question' => 'What does "hello" mean?',
                'option_a' => 'A farewell',
                'option_b' => 'A greeting',
                'option_c' => 'A thank you',
                'option_d' => 'A question',
                'correct_answer' => 'B',
                'explanation' => '"Hello" is used as a greeting when meeting someone.',
                'points' => 1
            ],
            [
                'question' => 'Which word means "used to express good wishes when parting"?',
                'option_a' => 'Hello',
                'option_b' => 'Please',
                'option_c' => 'Goodbye',
                'option_d' => 'Welcome',
                'correct_answer' => 'C',
                'explanation' => 'Goodbye is said when leaving or ending a conversation.',
                'points' => 1
            ],
            [
                'question' => 'What is the meaning of "thank you"?',
                'option_a' => 'Asking for something',
                'option_b' => 'Expressing gratitude',
                'option_c' => 'Making a request',
                'option_d' => 'Giving directions',
                'correct_answer' => 'B',
                'explanation' => 'Thank you is used to express appreciation or gratitude.',
                'points' => 1
            ],
        ];

        foreach ($questions1 as $question) {
            QuizQuestion::create(array_merge($question, ['quiz_id' => $quiz1->id]));
        }

        // Business English Quiz
        $quiz2 = Quiz::create([
            'title' => 'Business English Challenge',
            'description' => 'Test your knowledge of business terminology',
            'category_id' => 3,
            'type' => 'multiple_choice',
            'time_limit' => 15,
        ]);

        $questions2 = [
            [
                'question' => 'What is a "deadline"?',
                'option_a' => 'A type of meeting',
                'option_b' => 'The latest completion time',
                'option_c' => 'A business strategy',
                'option_d' => 'A negotiation tactic',
                'correct_answer' => 'B',
                'explanation' => 'A deadline is the time by which something must be completed.',
                'points' => 1
            ],
            [
                'question' => 'What does "negotiation" involve?',
                'option_a' => 'Writing reports',
                'option_b' => 'Discussions to reach agreement',
                'option_c' => 'Marketing products',
                'option_d' => 'Managing finances',
                'correct_answer' => 'B',
                'explanation' => 'Negotiation involves discussions between parties to reach a mutual agreement.',
                'points' => 1
            ],
        ];

        foreach ($questions2 as $question) {
            QuizQuestion::create(array_merge($question, ['quiz_id' => $quiz2->id]));
        }
    }
}