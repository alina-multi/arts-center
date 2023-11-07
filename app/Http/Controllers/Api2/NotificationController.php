<?php

namespace App\Http\Controllers\Api2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        return $request->user()->notifications;
    }

    public function markAllRead(Request $request)
    {
        return $request->user()->unreadNotifications->markAsRead();
    }
}
