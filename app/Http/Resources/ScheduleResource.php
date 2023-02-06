<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Doctor;
use App\Models\Patient;
use App\Http\Resources\PatientResource;
use App\Http\Resources\DoctorResource;


class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */


    public function toArray($request)
    {
    
        return [
            'id' => (int)$this->id,

            'status' => (string)$this->status,
            'type' => (string)$this->type,
            'code' => (string)$this->code,

            'date_time' => (string)$this->date,

            'patient' => new PatientResource($this->patients),
            'doctor' => new DoctorResource($this->doctors),

            'created_at' => (string)$this->created_at,
            
        ];
    }
}
