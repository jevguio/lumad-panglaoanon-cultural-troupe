<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/sass/app.scss',   'resources/js/app.js'])
</head>

<body>

    @auth

        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        <div class="container2 ">
            @include('partials.sidebar')
        @endauth
        <div class="content @auth ml-20 shifted @endauth ">
            <button id="toggleBtnOn" class="btn orange hidden">☰</button>
            @yield('content')
        </div>
        @auth
        </div>
    @endauth
    @if (session('success'))
        <div id="flash-message" class="flash-message">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(() => {
                const flash = document.getElementById('flash-message');
                if (flash) {
                    flash.style.opacity = '0';
                    setTimeout(() => flash.remove(), 500); // remove after fade
                }
            }, 4000);
        </script>

        <style>
            .flash-message {
                position: fixed;
                top: 20px;
                right: 20px;
                background-color: #4caf50;
                color: white;
                padding: 10px 16px;
                border-radius: 4px;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
                transition: opacity 0.5s ease;
                z-index: 9999;
            }
        </style>
    @endif

    @stack('scripts')
    <script>
        document.querySelectorAll("#sidebarMenu li").forEach(item => {
            item.addEventListener("click", function() {
                document.querySelectorAll("#sidebarMenu li").forEach(li => li.classList.remove("active"));
                this.classList.add("active");

                const link = this.getAttribute("data-link");
                if (link && link !== "#") {
                    window.location.href = link;
                }
            });
        });
        const toggleBtnOn = document.querySelector("#toggleBtnOn");
        document.getElementById("toggleBtnOn").addEventListener("click", function() {
            const sidebar = document.querySelector(".sidebar");
            const container = document.querySelector(".container");

            sidebar.classList.toggle("collapsed");
            container.classList.toggle("shifted");
            toggleBtnOn.classList.toggle("hidden");
            console.log(toggleBtnOn);
        });

        function toggleBtnOff() {
            const sidebar = document.querySelector(".sidebar");
            const container = document.querySelector(".container");
            console.log(toggleBtnOn);

            sidebar.classList.toggle("collapsed");
            container.classList.toggle("shifted");
            toggleBtnOn.classList.toggle("hidden");
        }
    </script>


</body>

</html>
