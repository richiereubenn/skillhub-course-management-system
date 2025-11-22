@extends('layouts.app')
@section('content')
    <div class="mb-6">
        <a href="{{ route('courses.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-900 font-medium rounded-lg hover:bg-gray-300 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to List
        </a>
    </div>

    <div class="bg-white rounded-lg border-2 border-gray-200 p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Course Detail</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-1">
                <p class="text-sm font-medium text-gray-500">Name</p>
                <p class="text-lg font-semibold text-gray-900">{{ $course->name }}</p>
            </div>
            
            <div class="space-y-1">
                <p class="text-sm font-medium text-gray-500">Instructor</p>
                <p class="text-lg text-gray-700">{{ $course->instructor }}</p>
            </div>
            <div class="space-y-1 ">
                <p class="text-sm font-medium text-gray-500">Schedule</p>
                <p class="text-lg text-gray-700">
                    {{ \Carbon\Carbon::parse($course->schedule)->format('l, d M Y H:i') }}
                </p>
            </div>
            <div class="space-y-1">
                <p class="text-sm font-medium text-gray-500">Description</p>
                <p class="text-lg text-gray-700">{{ $course->description }}</p>
            </div>
        </div>
    </div>
@endsection