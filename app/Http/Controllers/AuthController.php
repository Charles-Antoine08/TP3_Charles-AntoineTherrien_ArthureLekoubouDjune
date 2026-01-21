<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Enumerations\Roles;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Exception;

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
}
