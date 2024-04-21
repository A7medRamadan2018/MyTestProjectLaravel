<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            'Full_Name' => $this->full_name,
            'email' => $this->email,
            'job' => $this->job,
            'phone_number' => $this->phone_number,
            'birth_date' => $this->birth_date,
            'image' => Storage::disk('public')->url($this->image->url)
        ];
    }
    public function with(Request $request)
    {
        return [
            'message' => 'success user'
        ];
    }
}
