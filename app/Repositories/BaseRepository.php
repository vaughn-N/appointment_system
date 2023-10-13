<?php

namespace App\Repositories;
use Illuminate\Support\Facades\DB;


class BaseRepository
{
    public string $table = '';

    public string $column = '';

    public function __construct() {
        
    }


    public function select(string $query, array $bindings = []) 
    {
        return DB::select($query, $bindings);
    }

    public function responseJson($response) 
    {
        
    }

    // public function find
    
}
