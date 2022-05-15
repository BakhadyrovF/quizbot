<?php

namespace App\Handlers;

use App\Actions\SendRequestAction;
use App\Helpers\BotApiHelper;
use App\Models\User;
use Telegram\Bot\Helpers\Emojify;
use Telegram\Bot\Keyboard\Keyboard;

class LocalizationHandler
{
    /**
     * @param string $language
     * @return bool
     */
    protected function changeLanguage(string $language): bool
    {

        $chatId = BotApiHelper::getChatId();

        User::query()
                ->where('chat_id', '=', $chatId)
                ->update([
                    'locale' => $language
                ]);

        app()->setLocale($language);

        $button = Keyboard::make([
            'keyboard' => [
                [
                    Keyboard::button(['text' => Emojify::text(__('bot.commands.quiz-start'))])
                ]
            ],
            'resize_keyboard' => true
        ]);

        (new SendRequestAction())('sendMessage', 'POST', [
            'chat_id' => BotApiHelper::getChatId(),
            'text' => __('bot.language-changed'),
            'reply_markup' => $button
        ]);

        return true;
    }

    /**
     * @return bool
     */
    public function russian(): bool
    {
        return $this->changeLanguage('ru');
    }

    /**
     * @return bool
     */
    public function english(): bool
    {
        return $this->changeLanguage('en');
    }

    /**
     * @return bool
     */
    public function uzbek(): bool
    {
        return $this->changeLanguage('uz');
    }
}
