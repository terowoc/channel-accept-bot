<?php

namespace App\Telegram\Handlers;

use App\Models\Channel;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class SelectChannelHandler
{
    public function __invoke(Nutgram $bot, $id): void
    {
        $bot->answerCallbackQuery();

        $channel = Channel::find($id);
        $keyboard = InlineKeyboardMarkup::make()
            ->addRow(
                InlineKeyboardButton::make('Approve all requests', callback_data: 'approve-all '.$id),
            )
            ->addRow(
                InlineKeyboardButton::make('Cencel', callback_data: 'cencel'),
            );

        $bot->editMessageText(
            text: 'Channel: '.$channel->title,
            reply_markup: $keyboard
        );
    }
}
