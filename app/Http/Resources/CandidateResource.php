<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'candidate_id' =>$this->candidate_id,
            'full_name' =>$this->full_name,
            'phone' =>$this->phone,
            'address' =>$this->address,
            'joined_at' =>$this->created_at?->toDateString(),
            'cv' => new CvResource($this->whenLoaded('cv')), // لود هوشمند رابطه ها
            'applications' => ApplicationResource::collection($this->whenLoaded('application')),
        ];
    }
}
