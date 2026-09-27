<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel + Tailwind</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="rounded-xl bg-white p-10 shadow-xl">
            <h1 class="text-4xl font-bold text-blue-600">
                Tailwind is working!
            </h1>

            <p class="mt-4 text-gray-600">
                Laravel + Vite + Tailwind CSS v4
            </p>

            <p class="mt-4 text-gray-600">
                Test by: Angel Alaba
            </p>
        </div>
    </div>
</body>
</html>