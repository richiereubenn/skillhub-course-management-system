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

    <div class="bg-white rounded-lg border-2 border-gray-200 overflow-hidden" x-data="{ modalOpen: false }">
        <div class="p-6 border-b-2 border-gray-200 bg-blue-50 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900">Participants Registered</h3>
            <button @click="modalOpen=true"
                class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                Register Participant
            </button>
        </div>

        <div x-show="modalOpen" style="display:none" class="fixed inset-0 flex items-center justify-center z-50"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">

            <div class="absolute inset-0 bg-black opacity-50" @click="modalOpen=false"></div>

            <div class="bg-white rounded-lg p-6 z-10 w-full max-w-md border-2 border-blue-600">
                <h3 class="text-xl font-bold mb-4 text-gray-900">Register Participant</h3>

                <form method="POST" action="{{ route('courses.register', $course) }}">
                    @csrf
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Participant</label>
                            <select name="participant_id"
                                class="w-full p-3 border-2 border-gray-200 rounded-lg focus:border-blue-600 focus:outline-none">
                                <option value="">-- Select Participant --</option>
                                @foreach(\App\Models\Participant::all() as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Registration Date</label>
                            <input type="datetime-local" name="registration_date"
                            value="{{ old('registration_date') ?? now()->format('Y-m-d\TH:i') }}"
                                class="w-full p-3 border-2 border-gray-200 rounded-lg focus:border-blue-600 focus:outline-none" />
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" @click="modalOpen=false"
                            class="px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                            Register
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-blue-600">
                    <tr>
                        <th class="py-3 px-4 text-left font-semibold text-white">No</th>
                        <th class="py-3 px-4 text-left font-semibold text-white">Name</th>
                        <th class="py-3 px-4 text-left font-semibold text-white">Email</th>
                        <th class="py-3 px-4 text-left font-semibold text-white">Registration Date</th>
                        <th class="py-3 px-4 text-left font-semibold text-white">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($course->participants as $p)
                        <tr class="border-b border-gray-200 hover:bg-blue-50 transition">
                            <td class="py-3 px-4">{{ $loop->iteration }}</td>
                            <td class="py-3 px-4 font-medium">{{ $p->name }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $p->email }}</td>
                            <td class="py-3 px-4 text-gray-600">
                                {{ $p->pivot->registration_date ? \Carbon\Carbon::parse($p->pivot->registration_date)->toDayDateTimeString() : '-' }}
                            </td>
                            <td class="py-2">
                                <form method="POST" action="{{ route('courses.register.destroy', [$course, $p]) }}"
                                    onsubmit="return confirm('Remove registration?')">
                                    @csrf @method('DELETE')
                                    <button class="px-2 py-1 bg-red-500 text-white rounded">Delete</button>
                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 px-4 text-center text-gray-500">
                                No participants registered yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection