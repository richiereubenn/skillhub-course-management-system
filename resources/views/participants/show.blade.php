@extends('layouts.app')
@section('content')
    <div class="mb-6">
        <a href="{{ route('participants.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-900 font-medium rounded-lg hover:bg-gray-300 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back to List
        </a>
    </div>

    <div class="bg-white rounded-lg border-2 border-gray-200 p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Participant Detail</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-1">
                <p class="text-sm font-medium text-gray-500">Name</p>
                <p class="text-lg font-semibold text-gray-900">{{ $participant->name }}</p>
            </div>
            <div class="space-y-1">
                <p class="text-sm font-medium text-gray-500">Email</p>
                <p class="text-lg text-gray-700">{{ $participant->email }}</p>
            </div>
            <div class="space-y-1">
                <p class="text-sm font-medium text-gray-500">Phone</p>
                <p class="text-lg text-gray-700">{{ $participant->phone }}</p>
            </div>
            <div class="space-y-1">
                <p class="text-sm font-medium text-gray-500">Address</p>
                <p class="text-lg text-gray-700">{{ $participant->address }}</p>
            </div>
        </div>
    </div>
@endsection