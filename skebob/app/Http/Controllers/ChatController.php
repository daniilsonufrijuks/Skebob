<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use MalteKuhr\LaravelGPT\Facades\GPT;
class ChatController extends Controller
{
    public function chat(Request $request)
    {
        // Validate input
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        // Check if API key is available
        $apiKey = config('services.deepseek.api_key'); // using services

        if (empty($apiKey)) {
            Log::error('DeepSeek API key not found in environment');
            return response()->json([
                'reply' => 'AI service configuration error. Please contact support.'
            ], 500);
        }

        if (!str_starts_with($apiKey, 'sk-')) {
            Log::error('DeepSeek API key format invalid - should start with sk-');
            return response()->json([
                'reply' => 'AI service configuration error. Please contact support.'
            ], 500);
        }

        $client = new Client([
            'timeout' => 90,
            'verify' => false
        ]);

        try {
            $response = $client->post('https://api.deepseek.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'deepseek-chat',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a helpful assistant specialized in PC components and computer hardware.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $request->input('message')
                        ]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 500,
                ],
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            Log::info('DeepSeek API Response received successfully');

            // Check if the response structure is correct
            if (!isset($responseData['choices'][0]['message']['content'])) {
                Log::error('DeepSeek API unexpected response structure', [
                    'response' => $responseData
                ]);
                return response()->json([
                    'reply' => "Sorry, the AI service returned an unexpected response. Please try again.",
                ], 500);
            }

            return response()->json([
                'reply' => $responseData['choices'][0]['message']['content']
            ]);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            // Handle 4xx errors (like 401 Unauthorized)
            $statusCode = $e->getResponse()->getStatusCode();
            $responseBody = $e->getResponse()->getBody()->getContents();

            Log::error('DeepSeek API Client Error', [
                'status_code' => $statusCode,
                'response' => $responseBody,
                'message' => $e->getMessage()
            ]);

            if ($statusCode === 401) {
                return response()->json([
                    'reply' => 'Authentication failed with AI service. Please contact support.'
                ], 500);
            }

            return response()->json([
                'reply' => 'AI service temporarily unavailable. Please try again later.'
            ], 500);

        } catch (\GuzzleHttp\Exception\ServerException $e) {
            // Handle 5xx errors
            Log::error('DeepSeek API Server Error', [
                'status_code' => $e->getResponse()->getStatusCode(),
                'message' => $e->getMessage()
            ]);

            return response()->json([
                'reply' => 'AI service is experiencing issues. Please try again later.'
            ], 500);

        } catch (\Exception $e) {
            Log::error('ChatController unexpected error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'reply' => 'Sorry, I am currently unable to process your request. Please try again later.'
            ], 500);
        }
    }

    // Debug method to check API key status
    public function debugApiKey()
    {
        $apiKey = env('DEEPSEEK_API_KEY');

        return response()->json([
            'api_key_exists' => !empty($apiKey),
            'api_key_starts_with_sk' => str_starts_with($apiKey ?: '', 'sk-'),
            'api_key_length' => strlen($apiKey ?: ''),
            'api_key_first_10' => $apiKey ? substr($apiKey, 0, 10) : 'N/A',
            'api_key_last_10' => $apiKey ? substr($apiKey, -10) : 'N/A',
        ]);
    }
}
