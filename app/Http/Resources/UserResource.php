<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'job' => $this->job,
            'phone_number' => $this->phone_number,
            'birth_date' => $this->birth_date,
            'image' => $this->image
        ];
    }
    public function with(Request $request)
    {
        return [
            'message' => 'success user'
        ];
    }
}
