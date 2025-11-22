<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    protected $fillable = [
        'name', 
        'phone', 
        'email', 
        'address'
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'registrations')
            ->withPivot('registration_date', 'id')
            ->withTimestamps();
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
