<?php

namespace App\Telegram\Handlers;

use SergiX44\Nutgram\Nutgram;

class CencelCommandHandler
{
    public function __invoke(Nutgram $bot): void
    {
        $bot->answerCallbackQuery();
        $bot->deleteMessage($bot->chatId(), $bot->messageId());
    }
}
