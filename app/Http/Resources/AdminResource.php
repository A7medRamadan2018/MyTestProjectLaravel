<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            'image' => $this->image,
            'birth_date' => $this->birth_date,
            'created_at' =>$this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
    public function with(Request $request)
    {
        return [
            'message' => 'success Admin'
        ];
    }
}
