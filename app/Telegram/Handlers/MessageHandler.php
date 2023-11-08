<?php

namespace App\Telegram\Handlers;

use SergiX44\Nutgram\Nutgram;

class MessageHandler
{
    public function __invoke(Nutgram $bot): void
    {
        $text = $bot->message()->text;
        $chatId = $bot->userId();

        if (mb_stripos($text, "instagram.com/") !== false) {
            $caption = "$text\n\n@swiftsave_bot orqali yuklab olingan.";
            $bot->sendMessage('🎥 Iltimos kuting...');
            $url = json_decode(file_get_contents("https://shaha.u11117.xvest2.ru/Video%20Downloader/insta4.php?url=" . $text), true);

            if (empty($url)) {
                $bot->sendMessage('Yuklab olish imkoni yo\'q');
                exit;
            } else {
                if (count($url) > 1) {
                    $content = [];
                    $types = ['jpg' => 'photo', 'mp4' => 'video', 'png' => 'photo'];
                    foreach ($url as $key => $value) {
                        $content[] = ['type' => $types[$value['type']], 'media' => $value['link']];
                    }
                    $content[0]['caption'] = $caption . "\n" . $url[0]['title'];
                    $bot->sendMediaGroup(media: $content);
                    exit;
                } else {
                    $types = ['jpg' => 'photo', 'mp4' => 'video', 'png' => 'photo'];
                    $type = $types[$url[0]['type']];
                    switch ($type) {
                        case 'photo':
                            $bot->sendPhoto(
                                photo: $url[0]['link'],
                                caption: $caption . "\n" . $url[0]['title']
                            );
                            break;

                        case 'video':
                            $bot->sendVideo(
                                video: $url[0]['link'],
                                caption: $caption . "\n" . $url[0]['title']
                            );
                            break;
                    }
                    exit;
                }
            }
        }

            // $bot->deleteMessage($bot->chatId(), $bot->messageId());
    }
}
