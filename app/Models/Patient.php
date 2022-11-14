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

    ];

    protected $hidden = [];


    public function generate_code()
    {
        $code = "PAT".mt_rand(10000000, 99999999);

        if($this->code_exists($code))
        {
            return $this->generate_code();
        }
    }

    public function code_exists($code) 
    {
        return Patient::whereCode($code)->exists();
    }

    public function user()
    {
        return $this->belongsTo('App\Model\User', 'user_id');
    }

    public function schedule()
    {
        return $this->hasMany('App\Model\Schedule');
    }

    public function patient_records()
    {
        return $this->hasMany('App\Model\PatientRecord');
    }

}
