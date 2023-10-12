<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/jpg" href="{{ Storage::url('logopeque.png') }}" />
    <title>OFIUCO</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!--Sweet Alert 2-->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- FontAwsome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles -->
    @livewireStyles
</head>

<body @class([
    'font-sans antialiased',
    'bg-gray-800 text-white' => auth()->check() && auth()->user()->temaoscuro,
    'bg-gray-300' => auth()->guest() || !auth()->user()->temaoscuro,
])>
    <x-banner />

    <div class="h-screen flex flex-col">
        @livewire('navigation-menu')
        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif
        <div class="flex-grow">
            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <footer id="footer">
            <div class="flex flex-wrap w-5/6 min-[640px]:w-4/6 min-[760px]:w-2/6 mt-4 mx-auto text-xl">
                <a href="https://www.facebook.com/ofiuco.facebook/" class="flex flex-col mx-auto cursor-pointer">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="https://twitter.com/Ofiuco_X" class="flex flex-col mx-auto cursor-pointer">
                    <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="https://www.reddit.com/user/ofiuco_reddit/" class="flex flex-col mx-auto cursor-pointer">
                    <i class="fa-brands fa-reddit"></i>
                </a>
                <a href="https://www.instagram.com/ofiuco_insta_oficial/" class="flex flex-col mx-auto cursor-pointer">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="https://www.tiktok.com/@ofiuco_titok" class="flex flex-col mx-auto cursor-pointer">
                    <i class="fa-brands fa-tiktok"></i>
                </a>
            </div>
            <p xmlns:cc="http://creativecommons.org/ns#" xmlns:dct="http://purl.org/dc/terms/"
                class="flex flex-wrap justify-center items-center mt-5 mx-2">
                <a property="dct:title" rel="cc:attributionURL" href="https://github.com/NEBUR342/Ofiuco"
                    class="flex mr-1">
                    Ofiuco
                </a>
                by 
                <a rel="cc:attributionURL dct:creator" property="cc:attributionName" href="https://github.com/NEBUR342"
                    class="flex mx-1">
                    Rubén Álvarez Fernández
                </a>
                is licensed under
                <a class="flex ml-1" href="http://creativecommons.org/licenses/by/4.0/?ref=chooser-v1" target="_blank"
                    rel="license noopener noreferrer">
                    Attribution 4.0 International
                    <img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;"
                        src="https://mirrors.creativecommons.org/presskit/icons/cc.svg?ref=chooser-v1">
                    <img style="height:22px!important;margin-left:3px;vertical-align:text-bottom;"
                        src="https://mirrors.creativecommons.org/presskit/icons/by.svg?ref=chooser-v1">
                </a>
            </p>
            <div class="h-4"></div>
        </footer>
    </div>
    @stack('modals')
    @livewireScripts
</body>

</html>

