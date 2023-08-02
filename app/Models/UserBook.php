<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     schema="UserBook",
 *     required={"user_id", "book_id"},
 *     @OA\Property(property="user_id", type="integer", description="ID de l'utilisateur"),
 *     @OA\Property(property="book_id", type="integer", description="ID du livre"),
 *     @OA\Property(property="comments", type="string", description="Commentaires sur le livre"),
 *     @OA\Property(property="purchase_price", type="number", format="float", description="Prix d'achat du livre"),
 *     @OA\Property(property="selling_price", type="number", format="float", description="Prix de vente du livre"),
 *     @OA\Property(property="purchase_date", type="string", format="date", description="Date d'achat du livre"),
 *     @OA\Property(property="on_sale_date", type="string", format="date", description="Date de mise en vente du livre"),
 *     @OA\Property(property="sold_date", type="string", format="date", description="Date de vente du livre"),
 *     @OA\Property(property="conservation_state_id", type="integer", description="ID de l'état de conservation du livre"),
 *     @OA\Property(property="status_id", type="integer", description="ID du statut du livre")
 * )
 */
class UserBook extends Model
{
    use HasFactory;

    protected $table = 'user_book';
    protected $fillable = [
        'user_id',
        'book_id',
        'comments',
        'purchase_price',
        'selling_price',
        'purchase_date',
        'on_sale_date',
        'sold_date',
        'on_ebay' ,
        'ebay_url',
        'conservation_state_id',
        'status_id'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }

    public function conservationState()
    {
        return $this->belongsTo(ConservationState::class, 'conservation_state_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

}