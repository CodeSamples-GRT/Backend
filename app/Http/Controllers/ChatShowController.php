<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatRoomResource;
use App\Models\ChatRoom;
use Inertia\Inertia;

class ChatShowController extends Controller
{
    public function __invoke(ChatRoom $chatRoom)
    {
        return Inertia::render('Chat', [
            'room' => new ChatRoomResource($chatRoom),
        ]);
    }
}
