<?php

namespace App\Telegram\Commands;

use App\Models\Channel;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class ChannelsCommand extends Command
{
    protected string $command = 'channels';

    protected ?string $description = 'List all channels';

    public function handle(Nutgram $bot): void
    {
        $channels = Channel::all()->where('user_chat_id', $bot->userId());
        $keyboard = InlineKeyboardMarkup::make();
        foreach ($channels as $channel) {
            $keyboard->addRow(InlineKeyboardButton::make($channel->title, callback_data: 'channel '.$channel->id));
        }

        $bot->sendMessage(
            text: 'Kanallar:',
            reply_markup: $keyboard
        );
    }
}
