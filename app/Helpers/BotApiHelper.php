<?php

namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Telegram\Bot\Helpers\Emojify;

class BotApiHelper
{
    public static int $chatId;
    /**
     * @param string $method
     * @return string
     */
    public static function getLocalServerUrlWithMethod(string $method): string
    {
        return config('bot.server-url') . '/' . $method;
    }

    /**
     * @param array $data
     * @return mixed|void
     */
    public static function getChatId()
    {
        $data = request()->all();

        if(array_key_exists('message', $data)){
            $chatId = $data['message']['chat']['id'];
        }elseif (array_key_exists('callback_query', $data)){
            $chatId = $data['callback_query']['message']['chat']['id'];
        }elseif (array_key_exists('my_chat_member', $data)){
            $chatId = $data['my_chat_member']['chat']['id'];
        }

        return $chatId ?? null;

    }

    /**
     * @return mixed|void
     */
    public static function getCallbackData()
    {
        if(array_key_exists('callback_query', request()->all())){
            return request()->all()['callback_query']['data'];
        }
    }

    /**
     * @return mixed|void
     */
    public static function getCallbackQueryId()
    {
        if(array_key_exists('callback_query', request()->all())){
            return request()->all()['callback_query']['id'];
        }
    }

    /**
     * @return mixed
     */
    public static function getMessageId()
    {
        return array_key_exists('message', request()->all())
            ? request()->all()['message']['message_id']
            : request()->all()['callback_query']['message']['message_id'];
    }

    /**
     * @return array|string|null
     */
    public static function getModifiedCallbackData()
    {
        $callbackData = self::getCallbackData();

        if(isset($callbackData) && str_contains($callbackData, '_')){
            $specSymbolPosition = strpos($callbackData, '_');
            $uniqueId = substr($callbackData, $specSymbolPosition + 1);
            $methodName =  substr($callbackData, 0, $specSymbolPosition);

            return [$uniqueId, $methodName];
        }else{
            return $callbackData;
        }
    }

    /**
     * @return mixed|void
     */
    public static function getMessageText()
    {
        if(array_key_exists('message', request()->all())){
            return request()->all()['message']['text'];
        }
    }

    /**
     * @return string|bool
     */
    public static function getMultilingualCommand()
    {
        $text = self::getMessageText();
        if(isset($text)){
            $command = Emojify::translate(self::getMessageText());

            if(in_array($command, self::getMultilingualCommandsList())){
                return $command;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public static function getMultilingualCommandsList()
    {
        return [
            __('bot.commands.quiz-start'),
        ];
    }

    public static function getUsernameOrFirstname(User $user)
    {
        return is_null($user->username)
            ? $user->first_name
            : '@' . $user->username;
    }



}
