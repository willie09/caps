<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = $request->input('message');
        Log::info('Chatbot request received', ['message' => $message]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo', // or 'gpt-4o-mini' if available
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful fitness coach AI for gym members.'],
                    ['role' => 'user', 'content' => $message],
                ],
                'max_tokens' => 300, // limit length of reply
                'temperature' => 0.7, // creativity level
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $reply = $data['choices'][0]['message']['content'] ?? 'Sorry, no reply.';
            } else {
                $reply = 'Error: ' . $response->body();
            }

            Log::info('Chatbot response generated', ['reply' => $reply]);
            return response()->json(['reply' => $reply]);

        } catch (\Exception $e) {
            Log::error('Chatbot error', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
