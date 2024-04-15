<?php

namespace App\Http\Resources;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {
        $reviews = Review::with('product')->get();

        $total_rating = 0;
        $rating_count = count($reviews);

        foreach ($reviews as $review) {
            $total_rating += $review['rating'];
        }

        $average_rating = $rating_count > 0 ? $total_rating / $rating_count : 0;





        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image,
            'quantity' => $this->quantity,
            'category' => $this->category_id,
            'gender_category' => $this->genderCategory_id,
            'seller' => $this->seller_id,
            'status' => $this->status,
            'reviews' => $average_rating,
            'reviews_count' => $rating_count,

        ];
    }
}
