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
        'time_start',
        'time_end'
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
        return $this->belongsTo('App\Model\User', 'user_id');
    }

    public function patient()
    {
        return $this->belongsTo('App\Model\Schedule');
    }
    public function doctor()
    {
        return $this->belongsTo('App\Model\Doctor');
    }


}
