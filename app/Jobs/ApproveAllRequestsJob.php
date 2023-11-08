<?php

namespace App\Jobs;

use App\Models\Channel;
use App\Models\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Nutgram\Laravel\Facades\Telegram;

class ApproveAllRequestsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $id;

    /**
     * Create a new job instance.
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $channel = Channel::find($this->id);
        $requests = Request::all()->where('chat_id', $channel->chat_id);
        foreach ($requests as $request) {
            Telegram::approveChatJoinRequest($request->chat_id, $request->user_id);
            Request::where('id', $request->id)->delete();
        }
        Telegram::sendMessage('Done!', $channel->user_chat_id);
    }
}
