<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $table = 'schedules';

    protected $fillable = [
        'status',
        'type',
        'code',

        'date',
    ];

    protected $hidden = [];

    public function generate_code()
    {
        $code = "SCH".mt_rand(10000000, 99999999);

        if($this->code_exists($code))
        {
            return $this->generate_code();
        }

        return $code;
    }
    public function code_exists($code) {
        return Patient::whereCode($code)->exists();
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function patients()
    {
        return $this->belongsTo('App\Models\Patient','patient_id');
    }
    public function doctors()
    {
        return $this->belongsTo('App\Models\Doctor','doctor_id');
    }


}
