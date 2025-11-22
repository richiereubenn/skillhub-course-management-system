<?php

use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\RegistrationController;


use Illuminate\Support\Facades\Route;

Route::get('/', function() { return redirect()->route('participants.index'); });

Route::resource('participants', ParticipantController::class);
Route::resource('courses', CourseController::class);

Route::post('courses/{course}/register', [RegistrationController::class, 'store'])->name('courses.register');
Route::delete('courses/{course}/register/{participant}', [RegistrationController::class, 'destroy'])->name('courses.register.destroy');
