<?php

namespace App\Commands;

use App\Actions\SendRequestAction;
use App\Helpers\BotApiHelper;
use App\Models\User;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Helpers\Emojify;
use Telegram\Bot\Keyboard\Keyboard;

class StartCommand extends Command
{
    protected $name = 'start';

    protected $description = 'Get started!';

    public function handle()
    {
        $update = $this->getUpdate();

        $buttons = Keyboard::make([
            'keyboard' => [
                [
                    Keyboard::button(['text' => Emojify::text(__('bot.commands.quiz-start'))])
                ]
            ],
            'resize_keyboard' => true
        ]);

        $user = User::query()
            ->where('username', '=', $update->message->chat->username)
            ->first();

        if(is_null($user))
        {
            $user = User::create([
                'first_name' => $update->message->chat->firstName,
                'username' => $update->message->chat->username,
                'chat_id' => $update->message->chat->id
            ]);

            (new SendRequestAction())('sendMessage', 'POST', [
                'chat_id' => $update->message->chat->id,
                'text' => __('bot.first-one', ['username' => BotApiHelper::getUsernameOrFirstname($user)])
            ]);
        }

        (new SendRequestAction())('sendMessage', 'POST', [
            'chat_id' => $update->message->chat->id,
            'text' => __('bot.start-message'),
            'reply_markup' => $buttons
        ]);

    }
}
