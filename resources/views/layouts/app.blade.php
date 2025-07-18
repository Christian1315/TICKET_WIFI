<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{str_replace("_","-",env('APP_NAME'))}} | {{$title}}</title>
    <link rel="shortcut icon" href="{{asset('images/logo.png')}}" type="image/x-icon">

    <link rel="stylesheet" href="{{asset('styles/home.css')}}">
    <link rel="stylesheet" href="{{asset('styles/dashboard.css')}}">
    <link rel="stylesheet" href="{{asset('styles/bootstrap.css')}}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <!-- Alert 2 -->
    @include('sweetalert::alert')

    <div class="min-h-screen bg-slate-50">
        @include('layouts.navigation')
        <div class="flex flex-col sm:flex-row w-full">
            @include('layouts.sidebar2')
            <main class="flex-1 flex flex-col overflow-hidden bg-indigo-50 bg-dots-darker bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="{{asset('bootstrap.min.js')}}"></script>
    <!-- Jquery -->
    <script src="{{asset('jquery.min.js')}}"></script>
    @stack('scripts')
</body>

</html>