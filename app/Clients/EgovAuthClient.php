<?php

namespace App\Clients;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class EgovAuthClient
{
    public function login(string $nip, string $password): array
    {
        try {
            $response = Http::withBasicAuth(
                config('services.egov.username'),
                config('services.egov.password')
            )->withHeaders([
                'SIAK-KEY' => config('services.egov.key'),
            ])->asForm()->timeout(10)
                ->post(config('services.egov.url'), [
                    'username' => $nip,
                    'password' => $password,
                    'host' => 'simptlhp.siakkab.go.id',
                ]);

            return [
                'http_status' => $response->status(),
                'body' => $response->body(),
                'json' => $response->json(),
            ];
        } catch (ConnectionException $e) {
            report($e);
            throw new \RuntimeException(
                'Server autentikasi sedang tidak dapat dihubungi.'
            );
        }
    }
}
