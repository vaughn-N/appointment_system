<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $table = 'patients';

    protected $fillable = [
        'status',
        'type',

        'code',

        'first_name',
        'last_name',
        'gender',
        'birth_date',

        'contact_no',

        'deprecated'

    ];

    protected $hidden = [];


    public function generate_code()
    {
        $code = "PT".mt_rand(10000000, 99999999);

        if($this->code_exists($code)) {
            return $this->generate_code();
        }

        return $code;
    }

    public function code_exists($code)
    {
        return Patient::whereCode($code)->exists();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function schedules()
    {
        return $this->hasMany('App\Models\User');
    }


}
