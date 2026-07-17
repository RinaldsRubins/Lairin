<?php

namespace App\Http\Controllers;

use App\Models\GoogleOAuthToken;
use Google\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GoogleAuthController extends Controller
{
    public function redirect(): RedirectResponse
    {
        $client = $this->buildClient();

        return redirect()->away($client->createAuthUrl());
    }

    public function callback(Request $request): RedirectResponse
    {
        if ($request->filled('error')) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Google autentifikācija tika atcelta.');
        }

        if (! $request->filled('code')) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Trūkst autentifikācijas koda no Google.');
        }

        try {
            $client = $this->buildClient();
            $token = $client->fetchAccessTokenWithAuthCode($request->string('code')->toString());

            if (isset($token['error'])) {
                throw new \RuntimeException($token['error_description'] ?? $token['error']);
            }

            $record = GoogleOAuthToken::current() ?? new GoogleOAuthToken;
            $record->persistFromTokenResponse($token);

            return redirect()
                ->route('dashboard')
                ->with('success', 'Google kalendārs ir veiksmīgi savienots.');
        } catch (\Throwable $exception) {
            Log::error('Google OAuth callback failed.', [
                'error' => $exception->getMessage(),
            ]);

            return redirect()
                ->route('dashboard')
                ->with('error', 'Neizdevās savienot Google kalendāru. Lūdzu, mēģiniet vēlreiz.');
        }
    }

    protected function buildClient(): Client
    {
        $client = new Client;
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect_uri'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->setIncludeGrantedScopes(true);
        $client->setScopes([\Google\Service\Calendar::CALENDAR]);

        return $client;
    }
}
