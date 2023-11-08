<?php

namespace App\Jobs;

use App\Models\Message;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Nutgram\Laravel\Facades\Telegram;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class SendToAllMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Message $message)
    {
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::all();
        $keyboard = InlineKeyboardMarkup::make();

        if (! is_null($this->message->url)) {
            $keyboard->addRow(InlineKeyboardButton::make('Delete 🗑', callback_data: 'cencel'));
            $keyboard->addRow(InlineKeyboardButton::make('↗️', url: $this->message->url));
        } else {
            $keyboard = null;
        }

        foreach ($users as $user) {
            if (! is_null($this->message->image)) {
                Telegram::sendPhoto(
                    photo: url('storage/'.$this->message->image),
                    chat_id: $user->chat_id,
                    reply_markup: $keyboard,
                    caption: $this->message->content,
                    parse_mode: 'html'
                );
            } else {
                Telegram::sendMessage(
                    text: $this->message->content,
                    chat_id: $user->chat_id,
                    reply_markup: $keyboard,
                    parse_mode: 'html'
                );

            }
        }

        $this->message->update(['status' => 'bajarildi!']);
        Telegram::sendMessage(
            text: 'Barcha foydalanuvchilarga xabar yuborildi!',
            chat_id: config('nutgram.config.id'),
        );
    }
}
