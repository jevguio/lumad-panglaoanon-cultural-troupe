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
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>

    @auth

        <div class="sidebar-overlay" id="sidebarOverlay"></div>
        <div class="container2 ">
            @if (request()->is('dashboard'))
                @include('partials.sidebarClose')
            @else
                @include('partials.sidebar')
            @endif
        @endauth
        <div class="content @auth ml-20 shifted @endauth ">

            @if (request()->is('dashboard'))
                <div
                    style="position: sticky; top:0; width: 100%; padding: 10px; background-color: white; z-index: 100; display: flex;">
                    <div style="display: flex; flex: 1; padding: 10px;">
                        <img src="{{ asset('icons/avatar.png') }}" style="width: 40px;" />
                        <a href="{{ route('dashboard') }}"
                            style="text-decoration: none; font-weight: bold; padding-left: 10px; color: black; align-items: center; justify-content: center; vertical-align: middle; text-align: center; margin-top: auto; margin-bottom: auto; text-transform: capitalize;">{{ Auth::user()->type }}
                            Dashboard
                        </a>
                    </div>
                    <div style="display: flex;">

                        <a href="{{ route('dashboard') }}"
                            style="text-decoration: none; padding:10px;  color: black; align-items: center; justify-content: center; vertical-align: middle; text-align: center; margin-top: auto; margin-bottom: auto; text-transform: capitalize;">
                            Home
                        </a>

                        <a href="{{ route('events.index') }}"
                            style="text-decoration: none;  padding:10px;  color: black; align-items: center; justify-content: center; vertical-align: middle; text-align: center; margin-top: auto; margin-bottom: auto; text-transform: capitalize;">
                            Events
                        </a>
                        <a href="{{ route('costume.status') }}"
                            style="text-decoration: none;   padding:10px; color: black; align-items: center; justify-content: center; vertical-align: middle; text-align: center; margin-top: auto; margin-bottom: auto; text-transform: capitalize;">
                        </a>
                        <a href="{{ route('users.index') }}"
                            style="text-decoration: none;   padding:10px; color: black; align-items: center; justify-content: center; vertical-align: middle; text-align: center; margin-top: auto; margin-bottom: auto; text-transform: capitalize;">
                            Members
                        </a>
                        <div style="display: flex; border: black 1px solid; padding: 5px; margin: 10px;">

                            <input type="text" placeholder="Search in site" style="border: none;">
                            <button style="border: none; background-color: transparent;">🔍︎</button>
                        </div>
                    </div>
                </div>
            @endif

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
        document.getElementById("toggleBtnOn").addEventListener("click", function() {
            const sidebar = document.querySelector(".sidebar");
            const container = document.querySelector(".container");
            const logout = document.querySelector(".logout");
            const targ = document.querySelector(".targ");
            const targMenu = document.querySelector(".targMenu");
            const head = document.getElementById("headProf");
            const targ2 = document.querySelector(".targ2");
            const toggleBtnOn = document.querySelector("#toggleBtnOn");

            targ2.classList.toggle("hidden");
            logout.classList.toggle("hidden");
            targ.classList.toggle("hidden");
            targMenu.classList.toggle("hidden");
            head.classList.toggle("hidden");
            if (head.style.display == "flex") {
                head.style.display = "none"
            } else {
                head.style.display = "flex"
            }
            sidebar.classList.toggle("collapsed");
            container.classList.toggle("shifted");
            toggleBtnOn.classList.toggle("hidden");
            console.log(toggleBtnOn);
        });

        function toggleBtnOff() {
            const sidebar = document.querySelector(".sidebar");
            const toggleBtnOn = document.querySelector("#toggleBtnOn");
            const container = document.querySelector(".container");
            const logout = document.querySelector(".logout");
            const targ = document.querySelector(".targ");
            const targMenu = document.querySelector(".targMenu");
            const head = document.getElementById("headProf");
            const targ2 = document.querySelector(".targ2");

            targ2.classList.toggle("hidden");
            logout.classList.toggle("hidden");
            targ.classList.toggle("hidden");
            targMenu.classList.toggle("hidden");
            head.classList.toggle("hidden");
            if (head.style.display == "flex") {
                head.style.display = "none"
            } else {
                head.style.display = "flex"
            }
            sidebar.classList.toggle("collapsed");
            container.classList.toggle("shifted");
            toggleBtnOn.classList.toggle("hidden");
            console.log(toggleBtnOn);
        }
    </script>


</body>

</html>
