@extends('layouts.app')
@section('content')
    <div x-data="{
                modalOpen:false,
                isEdit:false,
                form:{
                    id:null, 
                    name:'', 
                    instructor:'', 
                    schedule_day:'', 
                    schedule_time:'', 
                    description:''
                },
                openCreate(){
                    this.isEdit = false;
                    this.form = { id:null, name:'', instructor:'', schedule:'', description:'' };
                    this.modalOpen = true;
                },
                openEdit(c){
                    this.isEdit = true;
                    this.form = { 
                    id:c.id, 
                    name:c.name, 
                    instructor:c.instructor, 
                    schedule:c.schedule ? c.schedule.replace(' ', 'T') : '', // convert to HTML datetime-local format
                    description:c.description 
                };
                this.modalOpen = true;
        }
            }">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-900">Courses</h2>
            <button @click="openCreate()"
                class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                Add Course
            </button>
        </div>

        <div x-show="modalOpen" style="display:none" class="fixed inset-0 flex items-center justify-center z-50"
            x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">

            <div class="absolute inset-0 bg-black opacity-50" @click="modalOpen=false"></div>

            <div class="bg-white rounded-lg p-6 z-10 w-full max-w-md border-2 border-blue-600">
                <h3 class="text-xl font-bold mb-4 text-gray-900" x-text="isEdit ? 'Edit Course' : 'Add Course'"></h3>

                <form method="POST" :action="isEdit ? '/courses/' + form.id : '{{ route('courses.store') }}'">
                    @csrf
                    <input type="hidden" name="_method" x-bind:value="isEdit ? 'PUT' : 'POST'">

                    <div class="space-y-3">
                        <input x-model="form.name" name="name" placeholder="Name"
                            class="w-full p-3 border-2 border-gray-200 rounded-lg focus:border-blue-600 focus:outline-none" />

                        <input x-model="form.instructor" name="instructor" placeholder="Instructor"
                            class="w-full p-3 border-2 border-gray-200 rounded-lg focus:border-blue-600 focus:outline-none" />

                        <input x-model="form.schedule" name="schedule" type="datetime-local"
                            class="w-full p-3 border-2 border-gray-200 rounded-lg focus:border-blue-600 focus:outline-none" />


                        <textarea x-model="form.description" name="description" placeholder="Description" rows="3"
                            class="w-full p-3 border-2 border-gray-200 rounded-lg focus:border-blue-600 focus:outline-none"></textarea>
                    </div>

                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" @click="modalOpen=false"
                            class="px-4 py-2 border-2 border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition"
                            x-text="isEdit ? 'Update' : 'Save'">
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-lg border-2 border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-blue-600">
                        <tr>
                            <th class="py-3 px-4 text-left font-semibold text-white">#</th>
                            <th class="py-3 px-4 text-left font-semibold text-white">Name</th>
                            <th class="py-3 px-4 text-left font-semibold text-white">Instructor</th>
                            <th class="py-3 px-4 text-left font-semibold text-white">Schedule</th>
                            <th class="py-3 px-4 text-left font-semibold text-white">Actions</th>
                            <th class="py-3 px-4 text-left font-semibold text-white">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($courses as $c)
                            <tr class="border-b border-gray-200 hover:bg-blue-50 transition">
                                <td class="py-3 px-4">{{ $c->id }}</td>
                                <td class="py-3 px-4 font-medium">{{ $c->name }}</td>
                                <td class="py-3 px-4 text-gray-600">{{ $c->instructor }}</td>
                                <td class="py-3 px-4 text-gray-600">
                                    {{ \Carbon\Carbon::parse($c->schedule)->format('l, d M Y H:i') }}
                                </td>

                                <td class="py-3 px-4">
                                    <div class="flex gap-2">
                                        <button
                                            @click="openEdit({ id:'{{ $c->id }}', name:'{{ $c->name }}', instructor:'{{ $c->instructor }}', schedule:'{{ addslashes($c->schedule) }}', description:'{{ addslashes($c->description) }}' })"
                                            class="px-3 py-1 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition">
                                            Edit
                                        </button>
                                        <form method="POST" action="{{ route('courses.destroy', $c) }}" class="inline-block"
                                            onsubmit="return confirm('Delete course?')">
                                            @csrf @method('DELETE')
                                            <button
                                                class="px-3 py-1 bg-red-500 text-white font-medium rounded-lg hover:bg-red-600 transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('courses.show', $c) }}"
                                        class="inline-block px-3 py-1 bg-gray-200 text-gray-900 font-medium rounded-lg hover:bg-gray-300 transition">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="p-4 bg-gray-50 border-t-2 border-gray-200">
                {{ $courses->links() }}
            </div>
        </div>
    </div>
@endsection