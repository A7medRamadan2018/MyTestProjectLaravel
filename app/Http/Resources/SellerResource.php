<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'birth_date' => $this->birth_date,
            'image' => Storage::disk('public')->url($this->image->url),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
    public function with(Request $request)
    {
        return [
            'message' => 'success Seller'
        ];
    }
}
