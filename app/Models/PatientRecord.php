<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientRecord extends Model
{
    use HasFactory;

    protected $table = 'patient_records';

    protected $fillable = [
        'status',
        'type',
        'code',

        'height',
        'width',
        'tempreture',

        'symptoms',

        'chief_complaint'
    ];

    protected $hidden = [];

    public function generate_code() {
        $code = "PTR".mt_rand(10000000, 99999999);

        if ($this->generate_code($code)) 
        {
            return $this->generate_code();
        }
    }

    public function code_exists($code) {
        return Patient::whereCode($code)->exists();
    }

    public function patient()
    {
        return $this->belongsTo('App\Model\Patient', 'patient_id');
    }
}
