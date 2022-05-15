<?php

namespace App\Commands;

use App\Actions\SendRequestAction;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Keyboard\Keyboard;

class LanguageCommand extends Command
{
    protected $name = 'language';

    protected $description = 'Change language!';

    public function handle()
    {
        $buttons = Keyboard::make([
            'inline_keyboard' => [
            [
                Keyboard::inlineButton(['text' => "Русский", 'callback_data' => 'russian']),
                Keyboard::inlineButton(['text' => "O'zbekcha", 'callback_data' => 'uzbek']),
                Keyboard::inlineButton(['text' => 'English', 'callback_data' => 'english']),
            ]
        ]]);

        (new SendRequestAction())('sendMessage', 'POST', [
            'chat_id' => $this->getUpdate()->message->chat->id,
            'text' => __('bot.language-select'),
            'reply_markup' => $buttons
        ]);
    }
}
