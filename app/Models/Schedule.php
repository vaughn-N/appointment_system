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

        'appointment_date',
        'start_at',
        'end_at'
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