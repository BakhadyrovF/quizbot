<?php

namespace App\Http\Controllers;

use App\Actions\SendRequestAction;
use App\Actions\SetLocaleAction;
use App\Commands\MultilingualCommands\MultilingualCommand;
use App\Handlers\CallbackHandler;
use App\Helpers\BotApiHelper;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Helpers\Emojify;
use Telegram\Bot\Objects\BotCommand;

class WebhookController extends Controller
{
    /**
     * @param Api $telegramApi
     * @param SetLocaleAction $setLocaleAction
     * @param CallbackHandler $callbackHandler
     * @return void
     */
    public function handle(Api $telegramApi, SetLocaleAction $setLocaleAction, CallbackHandler $callbackHandler, MultilingualCommand $multilingualCommand)
    {
        $setLocaleAction(BotApiHelper::getChatId());

        $multilingualCommand(BotApiHelper::getMultilingualCommand());
        $callbackHandler(BotApiHelper::getModifiedCallbackData());
        $telegramApi->commandsHandler(true);
    }

    /**
     * @return void
     */
    public function setMyCommands()
    {
        (new SendRequestAction())('setMyCommands', 'POST', [
            'commands' => [
                BotCommand::make([
                    'command' => '/start',
                    'description' => 'Погнали!'
                ]),
                BotCommand::make([
                    'command' => '/language',
                    'description' => 'Изменить язык!'
                ]),
            ]
        ]);
    }

}
