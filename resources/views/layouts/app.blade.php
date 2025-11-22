<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Course CMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-50 min-h-screen">
    <div class="flex">
        <aside class="w-64 bg-white min-h-screen border-r border-gray-200">
            <div class="p-6 border-b border-gray-200 bg-blue-600">
                <h1 class="text-xl font-bold text-white">Course CMS</h1>
            </div>
            <nav class="p-4">
                <a href="{{ route('participants.index') }}"
                    class="block py-3 px-4 rounded-lg transition {{ request()->routeIs('participants.*') ? 'bg-blue-600 text-white font-semibold' : 'text-gray-700 hover:bg-blue-50' }}">
                    Participants
                </a>
                <a href="{{ route('courses.index') }}"
                    class="block py-3 px-4 rounded-lg transition {{ request()->routeIs('courses.*') ? 'bg-blue-600 text-white font-semibold' : 'text-gray-700 hover:bg-blue-50' }}">
                    Courses
                </a>
            </nav>
        </aside>

        <main class="flex-1 p-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-blue-100 border-2 border-blue-600 text-gray-900 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 border-2 border-red-400 text-gray-900 rounded-lg">
                    <ul class="list-disc ml-5 space-y-1">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-lg border border-gray-200 p-6">
                @yield('content')
            </div>
        </main>
    </div>
</body>

</html>