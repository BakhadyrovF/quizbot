<?php

namespace App\Actions;

use App\Models\User;

class SetLocaleAction
{
    /**
     * @param int|string $chatId
     * @return void
     */
    public function __invoke(int|string $chatId): void
    {
        $user = User::query()
                ->where('chat_id', '=', $chatId)
                ->first();
        app()->setLocale($user->locale ?? 'ru');
    }
}
