<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Clients\RootAuthClient;
use App\Repositories\AccessLogRepository;
use App\Repositories\TimRepository;
use App\Repositories\UserRepository;
use App\Services\NamaOpdService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        protected RootAuthClient      $client,
        protected UserRepository      $userRepo,
        protected AccessLogRepository $accessLogRepo,
        protected TimRepository       $timRepo,
        protected NamaOpdService      $namaOpdService,
    ) {}

    public function login(string $nip, string $password): array
    {
        // 1. Hit SSO eksternal
        $result = $this->client->login($nip, $password);

        if (
            !$result ||
            empty($result['json']['status'])  // handles: null, false, 0, "", tidak ada key
        ) {
            throw ValidationException::withMessages([
                'password' => 'NIP atau password salah',
            ]);
        }

        $data = $result['json']['data'];
        // 2. Sipasti punya alur khusus
        if ($nip === 'sipasti') {
            return $this->handleSipastiLogin($data);
        }

        // 3. Cari user di DB lokal berdasarkan nip_baru dari SSO
        $user = $this->userRepo->findByIdPegawai($data['nip_baru']);
        if (!$user) {
            throw ValidationException::withMessages([
                'nip' => 'User tidak terdaftar di sistem lokal',
            ]);
        }

        // 4. Set Laravel Auth session
        Auth::login($user);
        request()->session()->regenerate();

        // 5. Resolve nama OPD dari simak
        $namaOpd   = $this->namaOpdService->resolveByKodeUnor($data['unor_root'] ?? '');
        $sessionId = (string) Str::uuid();

        // 6. Set semua session data (sesuai CI lama)
        session([
            'nip'        => $data['nip_baru'],
            'nama'       => $data['nama_pegawai'] ?? null,
            'id_pegawai' => $data['id_pegawai'],
            'level'      => $data['tingkatan_level'],
            'kode_unor'  => $data['unor_root'],
            'nama_opd'   => $namaOpd,
            'is_simak'   => $data['simak'] ?? false,
            'session_id' => $sessionId,
        ]);

        // 7. Set session tim berdasarkan level
        $this->resolveTimSession($data);

        // 8. Catat access log (audit trail)
        $this->recordAccessLog(
            sessionId: $sessionId,
            idPegawai: $data['nip_baru'],
            kodeUnor: $data['unor_root'] ?? '',
            level: (int) ($data['tingkatan_level'] ?? 0),
        );

        return [
            'message'  => 'Login berhasil',
            'redirect' => url('/dashboard'),
        ];
    }

    // ─────────────────────────────────────────────
    // Alur khusus untuk akun sipasti
    // ─────────────────────────────────────────────
    private function handleSipastiLogin(array $data): array
    {
        // Sipasti disimpan di kis_users dengan id_pegawai = 'sipasti'
        $user = $this->userRepo->findByIdPegawai('sipasti');
        if (!$user) {
            throw ValidationException::withMessages([
                'nip' => 'Akun sipasti tidak terdaftar di sistem lokal',
            ]);
        }

        Auth::login($user);
        request()->session()->regenerate();

        $namaOpd   = $this->namaOpdService->resolveByKodeUnor('01.15');
        $sessionId = (string) Str::uuid();

        session([
            'nip'        => 'sipasti',
            'nama'       => $data['nama'] ?? null,
            'id_pegawai' => $data['id_admin'] ?? null,
            'level'      => $data['level'] ?? null,
            'kode_unor'  => '01.15',
            'nama_opd'   => $namaOpd,
            'is_simak'   => false,
            'session_id' => $sessionId,
        ]);

        $this->recordAccessLog(
            sessionId: $sessionId,
            idPegawai: 'sipasti',
            kodeUnor: '01.15',
            level: (int) ($data['level'] ?? 0),
        );

        return [
            'message'  => 'Login berhasil',
            'redirect' => url('/dashboard'),
        ];
    }

    // ─────────────────────────────────────────────
    // Set session tim berdasarkan tingkatan level
    // ─────────────────────────────────────────────
    private function resolveTimSession(array $data): void
    {
        $level = (int) ($data['tingkatan_level'] ?? 0);

        match ($level) {
            2 => $this->setTimByIdUser($data['id_user'] ?? null),
            5 => $this->setTimByNipKetua($data['nip_baru'] ?? null),
            default => null,
        };
    }

    private function setTimByIdUser(mixed $idUser): void
    {
        if (!$idUser) {
            return;
        }
        $tim = $this->timRepo->findByIdUser($idUser);
        if ($tim) {
            session(['tim' => $tim->id_tim]);
        }
    }

    private function setTimByNipKetua(mixed $nipBaru): void
    {
        if (!$nipBaru) {
            return;
        }
        $tim = $this->timRepo->findByNipKetua($nipBaru);
        if ($tim) {
            session(['tim' => $tim->id]);
        }
    }

    // ─────────────────────────────────────────────
    // Catat audit log — jika gagal tidak break login
    // ─────────────────────────────────────────────
    private function recordAccessLog(
        string $sessionId,
        string $idPegawai,
        string $kodeUnor,
        int    $level,
    ): void {
        try {
            $ua       = request()->userAgent() ?? '';
            $this->accessLogRepo->create([
                'id_session' => $sessionId,
                'id_pegawai' => $idPegawai,
                'kode_unor'  => $kodeUnor,
                'level'      => $level,
                'login_at'   => now()->format('Y-m-d H:i:s'),
                'valid_thru' => now()->addHours(2)->format('Y-m-d H:i:s'),
                'browser'    => $this->parseBrowser($ua),
                'platform'   => $this->parsePlatform($ua),
            ]);
        } catch (\Throwable $e) {
            // Gagal log tidak boleh block proses login
            report($e);
        }
    }

    private function parseBrowser(string $ua): string
    {
        return match (true) {
            str_contains($ua, 'Edg')     => 'Microsoft Edge',
            str_contains($ua, 'Chrome')  => 'Chrome',
            str_contains($ua, 'Firefox') => 'Firefox',
            str_contains($ua, 'Safari')  => 'Safari',
            str_contains($ua, 'Opera')   => 'Opera',
            default                      => 'Unknown',
        };
    }

    private function parsePlatform(string $ua): string
    {
        return match (true) {
            str_contains($ua, 'Windows') => 'Windows',
            str_contains($ua, 'Android') => 'Android',
            str_contains($ua, 'iPhone')  => 'iOS',
            str_contains($ua, 'Linux')   => 'Linux',
            str_contains($ua, 'Mac')     => 'Mac',
            default                      => 'Unknown',
        };
    }
}
