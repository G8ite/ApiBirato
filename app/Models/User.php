<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * @OA\Schema(
 *     schema="User",
 *     required={"name", "email", "password", "role"},
 *     @OA\Property(
 *         property="fistname",
 *         type="string",
 *         description="Name of the user",
 *         example="Jean"
 *     ),
 *    @OA\Property(
 *        property="lastname",
 *        type="string",
 *        description="Surname of the user",
 *        example="Michem"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Email of the user",
 *         example="test@test.test"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="Password of the user",
 *         writeOnly=true,
 *         example="$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi"
 *     ),
 *     @OA\Property(
 *         property="role",
 *         type="boolean",
 *         description="Role of the user",
 *         example="0"
 *     ),
 *     @OA\Property(
 *         property="remember_token",
 *         type="string",
 *         nullable=true,
 *         description="Remember token of the user"
 *     )
 * )
 */
class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string, bool>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier(): int
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}

