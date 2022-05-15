<?php

namespace App\Actions;

use App\Helpers\BotApiHelper;
use Illuminate\Support\Facades\Http;

class SendRequestAction
{
    /**
     * @param string $telegramMethod
     * @param string $requestMethod
     * @param array $data
     * @return array|object
     */
    public function __invoke(string $telegramMethod, string $requestMethod = 'GET', array $data = []): array|object
    {
        if($requestMethod === 'POST'){
            return Http::post(BotApiHelper::getLocalServerUrlWithMethod($telegramMethod), $data)->object();
        }

        return Http::get(BotApiHelper::getLocalServerUrlWithMethod($telegramMethod))->object();
    }

}
