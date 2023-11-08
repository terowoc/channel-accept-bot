<?php

namespace App\Telegram\Commands;

use App\Models\User;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

class StartCommand extends Command
{
    protected string $command = 'start';

    protected ?string $description = 'Start';

    public function handle(Nutgram $bot): void
    {
        $data = [
            'name' => $bot->user()->first_name,
            'chat_id' => $bot->user()->id,
        ];
        User::firstOrCreate($data);
        $bot->sendMessage('👋 Salom, ' . $bot->user()->first_name . ' !
            
🇺🇿 Video yuklash uchun LINK Yuboring!
🇷🇺 Отправьте ссылку на видео.
🇺🇲 Send URL to Video.
______________________________

Bu bot sizga kanallardagi qo\'shilish so\'rovlarini ham qabul qilib beradi! 
Avto va tasdiqlagandan keyin qo\'shish rejimida ishlaydi!');
    }
}
