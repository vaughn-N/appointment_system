<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientSchedule extends Model
{
    use HasFactory;

    protected $table = 'patient_schedule';

    protected $fillable = [
        'patient_id',
        'schedule_id',

        'deprecated'
    ];


    public function patient()
    {
        return $this->belongsTo('App\Model\Patient', 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo('App\Model\Schedule');
    }
}
