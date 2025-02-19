<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationController\NotificationRequest;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function notification(NotificationRequest $request)
    {
        Notification::create([
            'user_id'   => auth()->id(),
            'author_id' => $request->author_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Notification created successfully',
        ]);
    }
}
