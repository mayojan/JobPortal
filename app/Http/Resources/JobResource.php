<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'job_id' =>$this->job_id,
            'job_title' =>$this->job_title,
            'description' =>$this->description,
            'salary' =>$this->salary,
            'location' =>$this->location,
            'deadline' =>$this->deadline,
            'posted_at' =>$this->created_at?->toDateString(),
            'employer' => new EmployerResource($this->whenLoaded('employer')), // لود هوشمند مشخصات کارفرای صاحب این شغل
            'applications' => ApplicationResource::collection($this->whenLoaded('application')),
        ];
    }
}
