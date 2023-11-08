<?php

namespace App\Telegram\Conversations;

use App\Models\Channel;
use SergiX44\Nutgram\Conversations\Conversation;
use SergiX44\Nutgram\Nutgram;

class ChannelConversation extends Conversation
{
    public function start(Nutgram $bot)
    {
        $bot->sendMessage('Kanalingizdan bironta postni forward qilib yuboring');
        $this->next('channelLink');
    }

    public function channelLink(Nutgram $bot)
    {
        $chatId = $bot->update()->message->forward_from_chat->id;
        $userId = $bot->user()->id;

        try {
            $getChatMemberStatus = $bot->getChatMember($chatId, $userId)->status->value;
            if ($getChatMemberStatus == 'creator' or $getChatMemberStatus == 'administrator') {

                try {
                    $type = $bot->getChat($chatId)->type->value;
                    $title = $bot->getChat($chatId)->title;
                    $username = $bot->getChat($chatId)->username;

                    if ($type == 'channel') {
                        $data = [
                            'title' => $title,
                            'chat_id' => $chatId,
                            'username' => $username,
                            'user_chat_id' => $userId,
                        ];
                        Channel::firstOrCreate($data);

                        $bot->sendMessage('Kanal muvaffaqiyattli qo\'shildi!', $userId);
                    } else {
                        $bot->sendMessage('Faqat kanal qoshish mumkin!');
                    }
                } catch (Exception $e) {
                    $bot->sendMessage('Faqat kanal qoshish mumkin!', $userId);
                }
            } else {
                $bot->sendMessage('Siz kanal yaratuvchisi yoki administratori emassiz!');
            }
        } catch (\Exception $e) {
            $bot->sendMessage('Kanal qo\'shish uchun iltimos avval botni kanalizda admin qilgandan so\'ng kanaldan botga post forward qiling!', $userId);
        }
        $this->end();
    }
}
