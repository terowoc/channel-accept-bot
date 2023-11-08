<?php

namespace App\Telegram\Handlers;

use App\Models\Request;
use SergiX44\Nutgram\Nutgram;

class CanJoinRequestHandler
{
    public function __invoke(Nutgram $bot)
    {
        $data = [
            'chat_id' => $bot->chatId(),
            'user_id' => $bot->userId(),
        ];

        Request::firstOrCreate($data);
    }
}
