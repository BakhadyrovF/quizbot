<?php

namespace App\Commands;

use App\Actions\SendRequestAction;
use Telegram\Bot\Commands\Command;

class HelpCommand extends Command
{
    protected $name = 'help';

    protected $description = 'How bot works?';

    public function handle()
    {
        (new SendRequestAction())->handle('sendMessage', 'POST', [
            'chat_id' => $this->getUpdate()->message->chat->id,
//            'text' =>
        ]);
    }

}
