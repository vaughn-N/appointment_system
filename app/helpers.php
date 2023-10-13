<?php

namespace App;

use Illuminate\Support\Facades\DB;

class Helpers
{
    public function select(string $query,array $bindings = [])
    {
        return DB::select($query, $bindings);
    }

    public function responseJson($response) {

        return response()->json($response);
    }

    public function responseJsonMeta($response) {

    }
}
