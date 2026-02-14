<?php

namespace App\Services\Telegram;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramService {

    private string $baseUrl;
    private string $token;

    public function __construct() {

        $this->token = config('services.telegram.token');
        $this->baseUrl = config('services.telegram.api');
    }

    public function sendMessage(string $chatId, string $text): void {
        try {
            Http::post("{$this->baseUrl}/bot{$this->token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML'
            ]);
        } catch(\Exception $e) {
            Log::error('Telegram sendMessage failed', [
            'chat_id' => $chatId,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        }
    }
}