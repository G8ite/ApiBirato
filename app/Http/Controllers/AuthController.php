<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @OA\Tag(
 *     name="Authentification",
 *     description="Endpoints pour l'authentification"
 * )
 */
class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Authentification de l'utilisateur",
     *     tags={"Authentification"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                     description="Adresse e-mail de l'utilisateur"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                     description="Mot de passe de l'utilisateur"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Authentification réussie",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="access_token",
     *                 type="string",
     *                 description="Jeton d'accès"
     *             ),
     *             @OA\Property(
     *                 property="token_type",
     *                 type="string",
     *                 description="Type de jeton (Bearer)"
     *             ),
     *             @OA\Property(
     *                 property="expires_in",
     *                 type="integer",
     *                 description="Durée de validité du jeton en secondes"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Non autorisé"
     *     )
     * )
     */
    public function login()
    {   
        // TODO: Mettre à jour le token de l'utilisateur
        //       Stocker le token dans le storage de l'application
        $credentials = request(['email', 'password']);

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    /**
     * @OA\Get(
     *     path="/api/auth/me",
     *     summary="Récupère l'utilisateur authentifié",
     *     tags={"Authentification"},
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur authentifié récupéré avec succès",
     *         @OA\JsonContent(
     *             type="object",
     *             description="Objet représentant l'utilisateur authentifié"
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Déconnecte l'utilisateur (invalide le jeton)",
     *     tags={"Authentification"},
     *     @OA\Response(
     *         response=200,
     *         description="Déconnexion réussie",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Message indiquant que la déconnexion s'est déroulée avec succès"
     *             )
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Post(
     *     path="/api/auth/refresh",
     *     summary="Actualise le jeton",
     *     tags={"Authentification"},
     *     @OA\Response(
     *         response=200,
     *         description="Jeton actualisé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="access_token",
     *                 type="string",
     *                 description="Nouveau jeton d'accès"
     *             ),
     *             @OA\Property(
     *                 property="token_type",
     *                 type="string",
     *                 description="Type de jeton (Bearer)"
     *             ),
     *             @OA\Property(
     *                 property="expires_in",
     *                 type="integer",
     *                 description="Durée de validité du nouveau jeton en secondes"
     *             )
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $expiration = JWTAuth::factory()->getTTL() * 60;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration
        ]);
    }
}
