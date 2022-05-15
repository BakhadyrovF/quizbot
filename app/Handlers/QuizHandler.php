<?php

namespace App\Handlers;

use App\Actions\SendRequestAction;
use App\Helpers\BotApiHelper;
use App\Models\Answer;
use Telegram\Bot\Keyboard\Button;
use Telegram\Bot\Keyboard\Keyboard;

class QuizHandler
{
    /**
     * @param int $answerId
     * @return bool
     */
    public function quizAnswer(int $answerId): bool
    {
        $buttons = Keyboard::make([
            'inline_keyboard' => [
                [
                    Keyboard::inlineButton(['text' => __('bot.quiz-continue'), 'callback_data' => 'quizContinue'])
                ]
            ]
        ]);

        $answer = Answer::find($answerId);

        $text = $answer->is_correct ? __('bot.answer-correct') : __('bot.answer-incorrect');

        (new SendRequestAction())('editMessageText', 'POST', [
            'chat_id' => BotApiHelper::getChatId(),
            'message_id' => BotApiHelper::getMessageId(),
            'text' => $text
        ]);

        return true;
    }
}
