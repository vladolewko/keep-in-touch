<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        
        @vite(['resources/css/app.css'])
        <link href="{{ asset('css/welcome.css') }}" rel="stylesheet" />



        <script>
          document.addEventListener('DOMContentLoaded', () => {

    const themedElement = document.getElementById('themed-element');
    const lightThemeClass = 'theme-light';
    const darkThemeClass = 'theme-dark';

    // Створюємо об'єкт для відстеження теми
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

    // Функція, яка оновлює класи
    function updateTheme(isDarkMode) {
        if (isDarkMode) {
            themedElement.classList.remove(lightThemeClass);
            themedElement.classList.add(darkThemeClass);
            console.log('Applied dark theme class.');
        } else {
            themedElement.classList.remove(darkThemeClass);
            themedElement.classList.add(lightThemeClass);
            console.log('Applied light theme class.');
        }
    }

    // 1. Застосовуємо тему при першому завантаженні сторінки
    updateTheme(mediaQuery.matches);

    // 2. Додаємо слухача, який буде реагувати на зміну системної теми
    mediaQuery.addEventListener('change', (event) => {
        updateTheme(event.matches);
    });

});
        </script>
    </head>
    <body>
        <!-- @php
        $themeClass = (isset($currentTheme) && $currentTheme === 'light') ? 'theme-light' : 'theme-dark';
      @endphp -->
        <!-- <div class="solid_bg {{ $themeClass }} dark:theme-dark theme-light"></div> -->
        <div class="solid_bg" id="themed-element"></div>

        <div class="glass-overlay"></div>

        <div class="container">
            <header>
                @if (Route::has('login'))
                    <nav>
                        @auth
                            <a href="{{ url('/profile/myProfile') }}" class="btn btn-glass">Profile</a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-glass">Log in</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-solid">Register</a>
                            @endif
                        @endauth
                    </nav>
                @endif
            </header>

            <main>
                <div class="hero">
                    <h1>Welcome to Keep in touch</h1>
                    <p class="subtitle">
                        Social network that helps you stay connected with friends, share moments, and never miss what matters most.
                    </p>
                </div>
            </main>

            <footer>
                <!-- Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }}) -->
                 © Keep-in-touch 2025
            </footer>
        </div>
    </body>
</html>