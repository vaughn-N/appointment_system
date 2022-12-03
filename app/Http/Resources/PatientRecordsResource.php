<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

use App\Models\PatientRecord;

class PatientRecordsResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this->collection->transform(function(PatientRecord $patient_record){
            return (new PatientRecordResource($patient_record));
        });

        return [
            'version' => '1.0.0',
            // 'author_url' => 'https://.tv',
            'data' => $this->collection
        ];
    
    
    }
}
