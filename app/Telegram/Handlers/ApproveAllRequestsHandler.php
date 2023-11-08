<?php

namespace App\Telegram\Handlers;

use SergiX44\Nutgram\Nutgram;
use App\Jobs\ApproveAllRequestsJob;

class ApproveAllRequestsHandler
{
    public function __invoke(Nutgram $bot, $id): void
    {
        $bot->deleteMessage($bot->chatId(), $bot->messageId());
        ApproveAllRequestsJob::dispatch($id);
    }
}
