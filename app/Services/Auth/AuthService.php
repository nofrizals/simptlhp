<?php

namespace App\Services\Auth;

use App\Clients\EgovAuthClient;
// use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        protected EgovAuthClient $client,
        protected UserRepository $userRepo
    ) {}

    public function login(string $nip, string $password): array
    {
        // 1. CALL SSO API
        $result = $this->client->login($nip, $password);

        if (
            !$result ||
            !isset($result['json']['status']) ||
            $result['json']['status'] !== true
        ) {
            throw ValidationException::withMessages([
                'password' => 'NIP atau password salah'
            ]);
        }
        $data = $result['json']['data'];

        // 3. AMBIL USER LOKAL
        $user = $this->userRepo->findByNip(
            $data['nip_baru']
        );
        if (!$user) {
            throw ValidationException::withMessages([
                'nip' => 'User tidak terdaftar di sistem lokal'
            ]);
        }

        // 4. LOGIN LARAVEL AUTH
        Auth::login($user);
        request()->session()->regenerate();
        return [
            'message' => 'Login berhasil',
            'redirect' => url('/dashboard')
        ];
    }
}
