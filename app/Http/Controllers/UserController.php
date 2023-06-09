<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Post(
     *     path="/api/profile",
     *     summary="Récupère le profil de l'utilisateur",
     *     tags={"Profil"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="user",
     *                     type="object",
     *                     description="Objet représentant l'utilisateur"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Profil de l'utilisateur récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 description="Objet représentant l'utilisateur"
     *             )
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
     */
    public function profile(Request $request)
    {
        return response()->json(['user' => $request->user()]);
    }

    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Récupère tous les utilisateurs",
     *     tags={"Utilisateurs"},
     *     @OA\Response(
     *         response=200,
     *         description="Liste des utilisateurs récupérée avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="users",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     description="Objet représentant un utilisateur"
     *                 )
     *             )
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
    */
    public function index()
    {
        return response()->json(['users' => \App\Models\User::all()]);
    }


    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Récupère un utilisateur par son ID",
     *     tags={"Utilisateurs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur récupéré avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 description="Objet représentant l'utilisateur"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
    */
    public function show($id)
    {
        return response()->json(['user' => \App\Models\User::find($id)]);
    }


    /**
     * @OA\Post(
     *     path="/api/users",
     *     summary="Crée un nouvel utilisateur",
     *     tags={"Utilisateurs"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="user",
     *                     type="object",
     *                     description="Objet représentant les informations de l'utilisateur",
     *                    @OA\Property(
     *                        property="name",
     *                        type="string",
     *                        description="Nom de l'utilisateur"),
     *                    @OA\Property(
     *                        property="email",
     *                        type="string",
     *                        description="Email de l'utilisateur"),
     *                    @OA\Property(
     *                        property="password",
     *                        type="string",
     *                        description="Mot de passe de l'utilisateur"),
     *                    @OA\Property(
     *                        property="role",
     *                        type="boolean",
     *                        description="Rôle de l'utilisateur (0 = utilisateur, 1 = administrateur)")
     *                )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Utilisateur créé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 description="Objet représentant l'utilisateur créé"
     *             )
     *         )
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
    */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|boolean',
        ]);

        $user = \App\Models\User::create($request->all());

        return response()->json(['user' => $user], 201);
    }


    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Met à jour un utilisateur existant",
     *     tags={"Utilisateurs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur à mettre à jour",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="user",
     *                     type="object",
     *                     description="Objet représentant les nouvelles informations de l'utilisateur"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur mis à jour avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="user",
     *                 type="object",
     *                 description="Objet représentant l'utilisateur mis à jour"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
    */
    public function update(Request $request, $id)
    {
        // On vérifie que l'utilisateur existe
        $user = \App\Models\User::findOrFail($id);
    
        // On met à jour seulement les données envoyées en requête
        $user->fill($request->all());
        $user->save();
    
        return response()->json(['user' => $user], 202);

        // Changer pour pas obliger à reremplir tous les champs lors du update
        // Demander à Alexandre
        
    }
    


    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     summary="Supprime un utilisateur",
     *     tags={"Utilisateurs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur à supprimer",
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Utilisateur supprimé avec succès",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 description="Message indiquant que l'utilisateur a été supprimé avec succès"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Utilisateur non trouvé"
     *     ),
     *     security={
     *         {"Bearer": {}}
     *     }
     * )
    */
    public function delete($id)
    {
        \App\Models\User::findOrFail($id)->delete();

        return response()->json(['message' => 'User deleted successfully'], 202);
    }

}
