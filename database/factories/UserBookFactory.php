<?php

namespace Database\Factories;

use App\Models\UserBook;
use App\Models\User;
use App\Models\Book;
use App\Models\ConservationState;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserBookFactory extends Factory
{
    protected $model = UserBook::class;

    public function definition()
    {
        $purchaseDate = Carbon::now()->subMonths(rand(1, 12));
        $onSaleDate = $this->faker->optional(0.5, null)->dateTimeBetween($purchaseDate, 'now');
        $booksIDs = Book::pluck('id')->toArray();
        $userIDs = User::pluck('id')->toArray();
        $conservationStateIDs = ConservationState::pluck('id')->toArray();
        $statusIDs = Status::pluck('id')->toArray();
        $soldDate = $this->faker->optional(0.3, null)->dateTimeBetween($onSaleDate ?? $purchaseDate, 'now');
        
        return [
            'user_id' => $this->faker->randomElement($userIDs),
            'book_id' => $this->faker->randomElement($booksIDs),
            'comments' => $this->faker->paragraph,
            'purchase_price' => $this->faker->randomFloat(2, 10, 100),
            'selling_price' => $this->faker->optional(0.5, null)->randomFloat(2, 10, 100),
            'purchase_date' => $purchaseDate,
            'on_sale_date' => $onSaleDate,
            'sold_date' => $soldDate,
            'on_ebay' => $this->faker->boolean,
            'ebay_url' => $this->faker->url,
            'conservation_state_id' => $this->faker->randomElement($conservationStateIDs),
            'status_id' => $this->faker->randomElement($statusIDs),
        ];
    }
}
