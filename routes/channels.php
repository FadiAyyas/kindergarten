<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/


Broadcast::channel('sendBusNotify.{bus_id}', function () {
    return Auth::check();
});

Broadcast::channel('newEvalNotify.{class_id}', function () {
    return Auth::check();
});

Broadcast::channel('employeeChatListener.{employee_id}', function () {
    return Auth::check();
});

Broadcast::channel('parentChatListener.{parent_id}', function () {
    return Auth::check();
});
