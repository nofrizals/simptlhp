<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Clients\EgovClient;
use App\Models\AccessLog;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use App\Exceptions\SsoUnavailableException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService,
        protected EgovClient  $egovClient,
    ) {}

    public function showLogin(Request $request): View
    {
        if ($request->get('ref')) {
            return view('auth.egov_checking', [
                'token' => $request->get('ref'),
            ]);
        }

        return view('auth.login');
    }

    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nip'      => 'required',
                'password' => 'required',
                'cf-turnstile-response' => 'required',
            ],
            [
                'nip.required'      => 'NIP/NIK wajib diisi.',
                'password.required' => 'Password wajib diisi.',
                'cf-turnstile-response.required' => 'Silakan selesaikan verifikasi keamanan.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $turnstileResponse = Http::asForm()->post(
                'https://challenges.cloudflare.com/turnstile/v0/siteverify',
                [
                    'secret'   => config('services.turnstile.secret_key'),
                    'response' => $request->input('cf-turnstile-response'),
                    'remoteip' => $request->ip(),
                ]
            );

            if (!$turnstileResponse->successful()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Gagal melakukan verifikasi keamanan.',
                ], 503);
            }

            $turnstile = $turnstileResponse->json();

            if (!($turnstile['success'] ?? false)) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Verifikasi keamanan gagal. Silakan coba lagi.',
                ], 422);
            }

            $result = $this->authService->login(
                $request->string('nip')->toString(),
                $request->string('password')->toString(),
            );

            return response()->json([
                'status'   => true,
                'message'  => 'Login berhasil',
                'redirect' => $result['redirect'],
            ]);
        } catch (ConnectionException $e) {
            // request ke Turnstile sendiri gagal terkoneksi
            report($e);
            return response()->json([
                'status'  => false,
                'message' => 'Gagal melakukan verifikasi keamanan. Silakan coba lagi.',
            ], 503);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'errors' => $e->errors(),
            ], 422);
        } catch (SsoUnavailableException $e) {
            // pesan sudah sengaja ditulis aman untuk user, boleh ditampilkan langsung
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 503);
        } catch (\Throwable $e) {
            report($e);
            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan sistem',
            ], 500);
        }
    }

    public function egovChecking(Request $request): JsonResponse
    {
        if (!$request->post('token')) {
            return response()->json([
                'status' => false,
                'msg'    => 'invalid credentials',
            ]);
        }

        try {
            $result = $this->egovClient->getUserByToken(
                $request->string('token')->toString()
            );
            return response()->json($result['json']);
        } catch (\RuntimeException $e) {
            return response()->json([
                'status' => false,
                'msg'    => $e->getMessage(),
            ], 503);
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'status' => false,
                'msg'    => 'Terjadi kesalahan server',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $sessionId = $request->session()->get('session_id');
        if ($sessionId) {
            AccessLog::where('id_session', $sessionId)->update([
                'valid_thru' => now(),
                'logout_at' => now(),
            ]);
        }
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
