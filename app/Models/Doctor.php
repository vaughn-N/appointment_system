<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $table = 'doctors';

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

    public function generate_code() {
        $code = "DOC".mt_rand(10000000, 99999999);

        if($this->code_exists($code)) {
            return $this->generate_code();
        }

        return $code;
    }

    public function code_exists($code) {
        return Patient::whereCode($code)->exists();
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
    public function patient() {

        return $this->belongsTo('App\Models\Patient', 'patient_id');
    }
    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule');
    }
}
