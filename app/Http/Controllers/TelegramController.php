<?php

namespace App\Http\Controllers;

use App\Telegram\Commands\ChannelsCommand;
use App\Telegram\Commands\InfoCommand;
use App\Telegram\Commands\StartCommand;
use App\Telegram\Conversations\ChannelConversation;
use App\Telegram\Handlers\CanJoinRequestHandler;
use App\Telegram\Handlers\MessageHandler;
use App\Telegram\Handlers\CencelCommandHandler;
use App\Telegram\Handlers\SelectChannelHandler;
use App\Telegram\Handlers\ApproveAllRequestsHandler;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\MessageType;

class TelegramController extends Controller
{
    public function __invoke(Nutgram $bot)
    {
        $bot->registerCommand(StartCommand::class);
        $bot->registerCommand(InfoCommand::class);
        $bot->registerCommand(ChannelsCommand::class);
        $bot->onChatJoinRequest(CanJoinRequestHandler::class);
        $bot->onMessageType(MessageType::TEXT, MessageHandler::class);
        $bot->onCallbackQueryData('cencel', CencelCommandHandler::class);
        $bot->onCallbackQueryData('channel {id}', SelectChannelHandler::class);
        $bot->onCallbackQueryData('approve-all {id}', ApproveAllRequestsHandler::class);
        $bot->onCommand('channel', ChannelConversation::class);
        // $bot->registerMyCommands();
        $bot->run();
    }
}
