<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

use App\Model\PatientLog;

use App\Http\Resource\PatientLogResource;


class PatientLogsResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this->collection->transform(function(PatientLog $patient_log){
            return (new PatientLogResource);
        });

        return parent::toArray($request);
    }
}
