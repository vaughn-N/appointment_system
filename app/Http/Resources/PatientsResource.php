<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

use App\Models\Patient;

class PatientsResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this->collection->transform(function(Patient $patient){
            return (new PatientResource($patient));
        });

        return [
            'version' => '1.0.0',
            // 'author_url' => 'https://.tv',
            'data' => $this->collection
        ];
    
    
    }
}
