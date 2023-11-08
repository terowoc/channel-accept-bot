<?php

namespace App\Telegram\Handlers;

use App\Jobs\ApproveAllRequestsJob;
use SergiX44\Nutgram\Nutgram;

class ApproveAllRequestsHandler
{
    public function __invoke(Nutgram $bot, $id): void
    {
        $bot->deleteMessage($bot->chatId(), $bot->messageId());
        ApproveAllRequestsJob::dispatch($id);
    }
}
