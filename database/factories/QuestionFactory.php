<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    protected static int $increment = 0;


    protected $questions = [
        'What is always coming but never arrives?',
        'Что всегда приходит но никогда не доходит?',
        'Nima har doim kelmoqchi boladi lekin hech qachon yetib kelmaydi?',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'text_en' => $this->questions[self::$increment++],
            'text_ru' => $this->questions[self::$increment++],
            'text_uz' => $this->questions[self::$increment++]
        ];



    }

}
