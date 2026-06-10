<?php

namespace App\Http\Controllers;

use App\Services\Auth\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'nip' => 'required',
                'password' => 'required',
            ],
            [
                'nip.required' => 'NIP/NIK wajib diisi.',
                'password.required' => 'Password wajib diisi.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $result = $this->authService->login(
                $request->nip,
                $request->password
            );

            return response()->json([
                'status' => true,
                'message' => 'Login berhasil',
                'redirect' => $result['redirect']
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception  $e) {
            report($e);
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan sistem'
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
