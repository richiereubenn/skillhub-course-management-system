<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'course_id', 
        'participant_id', 
        'registration_date'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }
}
