<?php

use App\Http\Controllers\ParticipantController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() { return redirect()->route('participants.index'); });

Route::resource('participants', ParticipantController::class);

