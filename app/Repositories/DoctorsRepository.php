<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Doctor;

class DoctorsRepository extends BaseRepository
{
    private string $table = 'doctors';



    public function __construct() {
        
    }
    public function find($limit = 10, $offset = 0)
    {
        $query = "SELECT * FROM $this->table LIMIT $limit, OFFSET $offset";

        $doctorList = $this->select($query);

        return $this->responseJson($doctorList);
    }

    public function findbyId($id, $limit = 10, $offset = 0)
    {
        $query = "SELECT * FROM $this->table WHERE doctor_id = :id LIMIT $limit OFFFSET $offset";


        $doctorList = $this->select($query, ['doctor_id => $id']);

        return $this->responseJson($doctorList);
    }
}
