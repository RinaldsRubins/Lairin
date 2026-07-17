<?php

namespace App\Models;

use Google\Client;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class GoogleOAuthToken extends Model
{
    protected $fillable = [
        'access_token',
        'refresh_token',
        'expires_at',
    ];

    protected $hidden = [
        'access_token',
        'refresh_token',
    ];

    protected function casts(): array
    {
        return [
            'expires_at' => 'datetime',
        ];
    }

    public function isExpired(): bool
    {
        return $this->expires_at === null || $this->expires_at->isPast();
    }

    public static function current(): ?self
    {
        return static::query()->latest('id')->first();
    }

    public function getValidClient(): Client
    {
        $client = $this->buildClient();

        if ($this->isExpired()) {
            if (empty($this->refresh_token)) {
                throw new RuntimeException('Google OAuth token is expired and no refresh token is available.');
            }

            $token = $client->fetchAccessTokenWithRefreshToken($this->refresh_token);

            if (isset($token['error'])) {
                throw new RuntimeException(
                    'Failed to refresh Google OAuth token: '.($token['error_description'] ?? $token['error'])
                );
            }

            $this->persistFromTokenResponse($token);
            $client->setAccessToken($token);
        } else {
            $client->setAccessToken($this->toAccessTokenArray());
        }

        return $client;
    }

    public function persistFromTokenResponse(array $token): void
    {
        $this->fill([
            'access_token' => $token['access_token'],
            'refresh_token' => $token['refresh_token'] ?? $this->refresh_token,
            'expires_at' => now()->addSeconds($token['expires_in'] ?? 3600),
        ])->save();
    }

    protected function buildClient(): Client
    {
        $client = new Client;
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect_uri'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->setScopes([\Google\Service\Calendar::CALENDAR]);
        $client->setIncludeGrantedScopes(true);

        return $client;
    }

    protected function toAccessTokenArray(): array
    {
        return [
            'access_token' => $this->access_token,
            'refresh_token' => $this->refresh_token,
            'expires_in' => $this->expires_at
                ? max(0, now()->diffInSeconds($this->expires_at, false))
                : 0,
            'created' => $this->updated_at?->getTimestamp() ?? time(),
        ];
    }
}
