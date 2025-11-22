<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 
        'description', 
        'schedule', 
        'instructor'
    ];

    public function participants()
    {
        return $this->belongsToMany(Participant::class, 'registrations')
            ->withPivot('registration_date', 'id')
            ->withTimestamps();
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}
