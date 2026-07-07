<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        @yield('title','VulkanStore')
    </title>

    @vite(['resources/css/app.css',
            'resources/js/app.js'])

</head>

<body class="bg-slate-100">
    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <main class="flex-1">
            @include('partials.navbar')

            <section class="p-6">
                @yield('content')
            </section>
        </main>
    </div>
</body>
</html>
