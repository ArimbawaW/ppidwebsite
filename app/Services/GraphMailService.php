<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class GraphMailService
{
    /**
     * Kirim email melalui Microsoft Graph API menggunakan client credentials.
     */
    public function send(string $to, string $subject, string $content, bool $saveToSent = true): bool
    {
        $token = $this->getToken();
        if (!$token) {
            return false;
        }

        $verify = filter_var(env('MS_GRAPH_SSL_VERIFY', true), FILTER_VALIDATE_BOOLEAN);

        $payload = [
            'message' => [
                'subject' => $subject,
                'body' => [
                    'contentType' => 'Text',
                    'content' => $content,
                ],
                'toRecipients' => [
                    ['emailAddress' => ['address' => $to]],
                ],
            ],
            'saveToSentItems' => $saveToSent ? 'true' : 'false',
        ];

        $sender = env('MS_MAIL_SENDER', config('mail.from.address'));

        $response = Http::withToken($token)
            ->withOptions(['verify' => $verify])
            ->withHeaders(['Content-Type' => 'application/json'])
            ->post(
                'https://graph.microsoft.com/v1.0/users/' . $sender . '/sendMail',
                $payload
            );

        if ($response->failed()) {
            Log::error('Graph sendMail failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return false;
        }

        return true;
    }

    private function getToken(): ?string
    {
        $verify = filter_var(env('MS_GRAPH_SSL_VERIFY', true), FILTER_VALIDATE_BOOLEAN);

        try {
            $response = Http::asForm()
                ->withOptions(['verify' => $verify])
                ->post(
                    'https://login.microsoftonline.com/' . env('MS_TENANT_ID') . '/oauth2/v2.0/token',
                    [
                        'grant_type' => 'client_credentials',
                        'client_id' => env('MS_CLIENT_ID'),
                        'client_secret' => env('MS_CLIENT_SECRET'),
                        'scope' => 'https://graph.microsoft.com/.default',
                    ]
                );
        } catch (Throwable $e) {
            Log::error('Graph token request exception', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);
            return null;
        }

        if ($response->failed()) {
            Log::error('Graph token request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return null;
        }

        return $response->json()['access_token'] ?? null;
    }
}

