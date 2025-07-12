<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Broadcast::channel('chat-global', function () {
//     return true;
// });

Broadcast::channel('order.user', function () {
    return true;
});

