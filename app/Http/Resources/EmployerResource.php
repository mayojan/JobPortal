<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'employer_id' => $this->employer_id, // کلید اصلی اختصاصی است
            'company_name' => $this->company_name,
            'phone' =>$this->phone,
            'address' =>$this->address,
            'registered_at' =>$this->created_at?->toDateString(), // تبدیل تاریخ میلادی ثبت شرکت به تاریخ کوتاه و خوانا
            'jobs' => JobResource::collection($this->whenLoaded('jobs')), // لودکردن هوشمند آگهی های شغلی این کارفرما در صورت  Eager Loading (جلوگیری از خطای N+1)
            
        ];
    }
}
