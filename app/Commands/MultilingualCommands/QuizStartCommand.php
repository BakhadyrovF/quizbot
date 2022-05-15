<?php

namespace App\Commands\MultilingualCommands;

use App\Actions\SendRequestAction;
use App\Helpers\BotApiHelper;
use App\Models\Question;
use App\Utilities\ModelUtility;
use Telegram\Bot\Keyboard\Keyboard;

class QuizStartCommand implements MultilingualContract
{
    /**
     * @param string $command
     * @return bool
     */
    public function hasCommand(string $command): bool
    {
        return $command === __('bot.commands.quiz-start');
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $question = Question::query()
            ->inRandomOrder()
            ->first();

        $answers = $question->answers()
            ->inRandomOrder()
            ->get();

        $buttons = Keyboard::make([
            'inline_keyboard' => [
                [
                    Keyboard::inlineButton(['text' => ModelUtility::getTranslatedText($answers[0], 'text'), 'callback_data' => 'quizAnswer_' . $answers[0]->id]),
                    Keyboard::inlineButton(['text' => ModelUtility::getTranslatedText($answers[1], 'text'), 'callback_data' => 'quizAnswer_' . $answers[1]->id])
                ],
                [
                    Keyboard::inlineButton(['text' => ModelUtility::getTranslatedText($answers[2], 'text'), 'callback_data' => 'quizAnswer_' . $answers[2]->id]),
                    Keyboard::inlineButton(['text' => ModelUtility::getTranslatedText($answers[3], 'text'), 'callback_data' => 'quizAnswer_' . $answers[3]->id])
                ]
            ]
        ]);

        (new SendRequestAction())('sendMessage', 'POST', [
            'chat_id' => BotApiHelper::getChatId(),
            'text' => ModelUtility::getTranslatedText($question, 'text'),
            'reply_markup' => $buttons
        ]);
    }
}
