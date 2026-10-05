<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('admin-notifications', function ($user) {
    return $user && $user->role === 'admin';
});

Broadcast::channel('user-notifications-{id}', function ($user, $id) {
    return $user && (int) $user->id === (int) $id;
});
