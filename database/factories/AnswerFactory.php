<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    protected static int $increment = 0;

    protected array $answers = [
        'Happiness',
        'Счастье',
        'Baxt',
        'Tomorrow',
        'Завтра',
        'Ertaga',
        'Satisfaction',
        'Удовлетворение',
        'Qoniqish',
        'Apocalypse',
        'Апокалипсис',
        'Apokalipsis',
    ];


    /**
     *   I couldn't find a free translator API, I had to write bad code and added only 1 question
     */


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'text_en' => $this->answers[self::$increment++],
            'text_ru' => $this->answers[self::$increment++],
            'text_uz' => $this->answers[self::$increment++],
            'question_id'=> 1,
            'is_correct' => self::$increment === 6,
        ];
    }
}
