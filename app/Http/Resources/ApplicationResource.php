<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'application_id' =>$this->application_id,
            'status' =>$this->status,
            'applied_at' =>$this->created_at?->toDateString(),
            'job' => new JobResource($this->whenLoaded('job')), // لود هوشمند شغل و کارجوی مربوط به این درخواست
            'candidate' => new CandidateResource($this->whenLoaded('candidate')),
        ];
    }
}
