<?php

namespace App\Handlers;


use App\Actions\SendRequestAction;
use App\Helpers\BotApiHelper;

class CallbackHandler
{
    protected array $allHandlers = [
        LocalizationHandler::class,
        QuizHandler::class
    ];

    /**
     * @param string|null $data
     * @return void
     */
    public function __invoke(array|string|null $method): void
    {
        if(is_null($method)){
            return;
        }elseif (is_array($method)){
            list($uniqueId, $method) = $method;
        }

        $callbackQueryId = BotApiHelper::getCallbackQueryId();
        foreach ($this->allHandlers as $class){
            if(method_exists($class, $method)){
                (new SendRequestAction())('answerCallbackQuery', 'POST', [
                    'callback_query_id' => $callbackQueryId,
                ]);
                call_user_func([new $class(), $method], $uniqueId ?? null);
            }
        }
    }



}
