<?php

namespace App\Clients;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class RootAuthClient
{
    public function login(string $nip, string $password): array
    {
        try {
            $response = Http::withBasicAuth(
                config('services.root.username'),
                config('services.root.password')
            )->withHeaders([
                'SIAK-KEY' => config('services.root.key'),
            ])->asForm()->timeout(10)
                ->post(config('services.root.url'), [
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
