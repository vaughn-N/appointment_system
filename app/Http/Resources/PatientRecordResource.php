<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientRecordResource extends JsonResource
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

            'height' => (string)$this->height,
            'weight' => (string)$this->weight,
            'tempreture' => (string)$this->tempreture,
            'symptoms' => (string)$this->symptoms,
            'complaint' => (string)$this->complaint,

            'created_at' => (string)$this->created_at,

            
        ];
    }
}
