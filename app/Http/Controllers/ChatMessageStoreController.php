<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageCreated;
use App\Http\Requests\StoreChatRoomMessageRequest;
use App\Http\Resources\ChatMessageResource;
use App\Models\ChatRoom;
use Illuminate\Support\Facades\Auth;

class ChatMessageStoreController extends Controller
{
    public function __invoke(ChatRoom $chatRoom, StoreChatRoomMessageRequest $request)
    {
        $chatMessage = $chatRoom->messages()->make($request->validated());
        $chatMessage->user()->associate(Auth::user());
        $chatMessage->save();

        broadcast(new ChatMessageCreated($chatMessage))->toOthers();

        return new ChatMessageResource($chatMessage);
    }
}
