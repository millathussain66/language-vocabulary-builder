<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Word;
use Illuminate\Database\Seeder;

class WordSeeder extends Seeder
{
    public function run(): void
    {
        $words = [
            // Basic Vocabulary
            [
                'category_id' => 1,
                'word' => 'hello',
                'meaning' => 'Used as a greeting or to begin a conversation',
                'pronunciation' => 'həˈloʊ',
                'example_sentence' => 'Hello, how are you today?',
                'difficulty' => 'beginner'
            ],
            [
                'category_id' => 1,
                'word' => 'goodbye',
                'meaning' => 'Used to express good wishes when parting',
                'pronunciation' => 'ɡʊdˈbaɪ',
                'example_sentence' => 'She waved goodbye to her friends.',
                'difficulty' => 'beginner'
            ],
            [
                'category_id' => 1,
                'word' => 'thank you',
                'meaning' => 'A polite expression used when acknowledging a gift, service, or compliment',
                'pronunciation' => 'θæŋk juː',
                'example_sentence' => 'Thank you for your help with the project.',
                'difficulty' => 'beginner'
            ],

            // Travel & Tourism
            [
                'category_id' => 2,
                'word' => 'itinerary',
                'meaning' => 'A planned route or journey',
                'pronunciation' => 'aɪˈtɪnəˌrɛri',
                'example_sentence' => 'Our travel itinerary includes visits to three countries.',
                'difficulty' => 'intermediate'
            ],
            [
                'category_id' => 2,
                'word' => 'accommodation',
                'meaning' => 'A place where someone may live or stay',
                'pronunciation' => 'əˌkɒməˈdeɪʃən',
                'example_sentence' => 'We booked our accommodation near the beach.',
                'difficulty' => 'intermediate'
            ],
            [
                'category_id' => 2,
                'word' => 'sightseeing',
                'meaning' => 'The activity of visiting places of interest in a particular location',
                'pronunciation' => 'ˈsaɪtˌsiːɪŋ',
                'example_sentence' => 'We spent the day sightseeing in the old town.',
                'difficulty' => 'beginner'
            ],

            // Business English
            [
                'category_id' => 3,
                'word' => 'negotiation',
                'meaning' => 'Discussion aimed at reaching an agreement',
                'pronunciation' => 'nɪˌɡoʊʃiˈeɪʃən',
                'example_sentence' => 'The business negotiation lasted for several hours.',
                'difficulty' => 'advanced'
            ],
            [
                'category_id' => 3,
                'word' => 'deadline',
                'meaning' => 'The latest time or date by which something should be completed',
                'pronunciation' => 'ˈdɛdlaɪn',
                'example_sentence' => 'We need to meet the project deadline next week.',
                'difficulty' => 'intermediate'
            ],
            [
                'category_id' => 3,
                'word' => 'strategy',
                'meaning' => 'A plan of action designed to achieve a long-term or overall aim',
                'pronunciation' => 'ˈstrætədʒi',
                'example_sentence' => 'The company developed a new marketing strategy.',
                'difficulty' => 'advanced'
            ],

            // Academic Vocabulary
            [
                'category_id' => 4,
                'word' => 'hypothesis',
                'meaning' => 'A proposed explanation made on the basis of limited evidence',
                'pronunciation' => 'haɪˈpɒθɪsɪs',
                'example_sentence' => 'The researcher tested her hypothesis through experiments.',
                'difficulty' => 'advanced'
            ],
            [
                'category_id' => 4,
                'word' => 'methodology',
                'meaning' => 'A system of methods used in a particular area of study or activity',
                'pronunciation' => 'ˌmɛθəˈdɒlədʒi',
                'example_sentence' => 'The paper explains the research methodology in detail.',
                'difficulty' => 'advanced'
            ],

            // Food & Dining
            [
                'category_id' => 5,
                'word' => 'appetizer',
                'meaning' => 'A small dish of food or drink taken before a meal to stimulate the appetite',
                'pronunciation' => 'ˈæpɪtaɪzər',
                'example_sentence' => 'We ordered shrimp cocktail as an appetizer.',
                'difficulty' => 'intermediate'
            ],
            [
                'category_id' => 5,
                'word' => 'cuisine',
                'meaning' => 'A style or method of cooking, especially as characteristic of a particular country or region',
                'pronunciation' => 'kwɪˈziːn',
                'example_sentence' => 'I love trying different types of cuisine when I travel.',
                'difficulty' => 'intermediate'
            ],
        ];

        foreach ($words as $word) {
            Word::create($word);
        }

        // Add more random words
        Word::factory(50)->create();
    }
}