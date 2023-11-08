<?php

namespace App\Telegram\Commands;

use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

class InfoCommand extends Command
{
    protected string $command = 'info';

    protected ?string $description = 'Info';

    public function handle(Nutgram $bot): void
    {
        $bot->sendMessage('This is a command!');
    }
}
