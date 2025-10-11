<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script>
window.dataLayer = window.dataLayer || [];
</script>
        <!-- Scripts -->
        @vite([
    'resources/css/app.css',
     'resources/js/app.js',
     'resources/js/like-publication.js',
     'resources/js/repost-publication.js',
     'resources/js/comment-menu.js',
     'resources/js/like-comment.js',

     ])
    </head>
    <body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 relative bg-fixed bg-cover bg-center dark:bg-[url('../../../public/images/background-dark.jpg')] bg-[url('../../../public/images/background-light.png')]">
      
        <!-- <img id="background" class="absolute inset-0 object-cover w-full h-full z-0" src="{{ asset('images/background.jpg') }}" alt="Laravel background" /> -->

        <div class="relative z-10">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white bg-opacity-75 dark:bg-gray-800 dark:bg-opacity-75 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </div>
    </body>
</html>
