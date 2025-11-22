<?php

use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\CourseController;

use Illuminate\Support\Facades\Route;

Route::get('/', function() { return redirect()->route('participants.index'); });

Route::resource('participants', ParticipantController::class);
Route::resource('courses', CourseController::class);


