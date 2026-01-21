<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};
use App\Enumerations\Roles;
use App\Http\Controllers\Controller;
use App\Http\Requests\{LoginRequest, RegisterRequest};
use App\Models\User;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'login'      => $request->login,
                'email'      => $request->email,
                'password'   => Hash::make($request->password),
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'role_id'    => Roles::USER->value,
            ]);

            return response()->json([
                'message' => 'User créé avec succès',
                'user' => $user
            ], Response::HTTP_CREATED);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de l’inscription'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function login(LoginRequest $request)
    {
        try {
            if (!Auth::attempt([
                'login'    => $request->login,
                'password' => $request->password,
            ])) {
                return response()->json([
                    'error' => 'Identifiants invalides'
                ], Response::HTTP_UNAUTHORIZED);
            }

            $user = Auth::user();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'user'  => $user,
                'token' => $token
            ], Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la connexion'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            return response()->json(null, Response::HTTP_NO_CONTENT);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la déconnexion'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }









    
}
