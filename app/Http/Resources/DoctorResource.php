<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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

            'first_name' => (string)$this->first_name,
            'last_name' => (string)$this->last_name,
            'gender' => (string)$this->gender,
            'contact_no' => (string)$this->contact_no,
            
        ];
    }
}
