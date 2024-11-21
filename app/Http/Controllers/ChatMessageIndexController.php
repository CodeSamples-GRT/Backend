<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatMessageResource;
use App\Models\ChatRoom;

class ChatMessageIndexController extends Controller
{
    public function __invoke(ChatRoom $chatRoom)
    {
        return ChatMessageResource::collection(
            $chatRoom->messages()->with('user')->latest()->latest('id')->cursorPaginate(6)
        );
    }
}
