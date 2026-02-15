<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\Request;

class TelegramWebhookController extends Controller
{
    public function __invoke(Request $request, UserRepositoryInterface $users)
    {
        $chatId = $request->input('message.chat.id');
        $username = $request->input('message.chat.username');

        if (!$chatId || !$username) {
            return response()->json(['ok' => true]);
        }

        $user = $users->findByUsername($username);

        if (!$user) {
            return response()->json(['ok' => true]);
        }

        $users->update($user, [
            'telegram_chat_id' => $chatId
        ]);

        return response()->json(['ok' => true]);
    }
}