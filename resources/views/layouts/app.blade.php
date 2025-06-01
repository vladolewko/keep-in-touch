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
<!-- Google Tag Manager -->
<script>
    (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-12345678');
</script>
<!-- End Google Tag Manager -->

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
        <!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-12345678" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 relative">
        <img id="background" class="absolute inset-0 object-cover w-full h-full z-0" src="{{ asset('images/background.jpg') }}" alt="Laravel background" />

        <div class="relative z-10"> <!-- Add this wrapper div with a higher z-index -->
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
