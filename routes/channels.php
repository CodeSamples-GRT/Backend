<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat.{roomId}', function (User $user, $roomId) {
    return $user->only('id', 'name');
});