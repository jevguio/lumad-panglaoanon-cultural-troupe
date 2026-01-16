<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<?php
error_reporting(E_ALL & ~E_DEPRECATED);

?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/main.min.css" rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
    <!-- Scripts -->
    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
  <link rel="icon" type="image/x-icon" href="{{ asset('images/logo.png') }}">

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
                        <div
                            style="display: flex; border: 1px solid #ccc; padding-right: 10px; margin-bottom: 15px; border-radius: 8px; width: 300px; position: relative;">
                            <input id="searchInput" type="text" placeholder="Search Events or Costumes..."
                                style="border: none; outline: none; flex: 1;border-radius: 8px;">
                            <button style="border: none; background: transparent;">🔍</button>

                            <div id="searchResults"
                                style="border: 1px solid #ccc; background-color: #ccc; border-radius: 5px; padding: 10px; display:block; max-height: 300px; overflow-y:auto; position: absolute; top: 55px;  flex:1;">

                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class=" " style="flex:1; overflow-x:hidden;  overflow-y:auto;">
                @yield('content')
            </div>
        </div>
        @auth
        </div>
    @endauth
    @if (session('success'))
        <div id="flash-message" class="flash-message">
            {{ session('success') }}
        </div>
    @endif

    <script>
        let allData = [];

        fetch("{{ route('search.item') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({})
            })
            .then(res => res.json())
            .then(data => {
                allData = data.allData; 
            });

        const input = document.getElementById('searchInput');
        const resultsBox = document.getElementById('searchResults');

        input.addEventListener('keyup', function() {
            let query = input.value.toString().toLowerCase();

            if (query.length < 1) {
                resultsBox.style.display = "none";
                return;
            }
            let filtered = allData.filter(item =>
                item.name ? item.name.toLowerCase().includes(query) : item.title ? item.title.toLowerCase()
                .includes(query) : item.venue ? item.venue.toLowerCase().includes(query) : item.type
                .toLowerCase().includes(query)
            );

            resultsBox.innerHTML = "";

            if (filtered.length === 0) {
                resultsBox.innerHTML = "<p>No results found.</p>";
            } else {
                filtered.forEach(item => {
                    resultsBox.innerHTML += `
                <div style="display:flex; align-items:center; gap:12px; padding:8px; border-bottom:1px solid #eee; cursor:pointer;"
                     onclick="window.location='/${item.type??item.status}s/view/${item.id}'">
 

                    <div>
                        <strong>${item.name??item.title}</strong>
                        <p style="margin:0; font-size:12px; color:gray;">${item.type??item.status}</p>
                    </div>
                </div>
            `;
                });
            }

            resultsBox.style.display = "block";
        });
        setTimeout(() => {
            const flash = document.getElementById('flash-message');
            if (flash) {
                flash.style.opacity = '0';
                setTimeout(() => flash.remove(), 500); // remove after fade
            }
        }, 4000);
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

    @stack('scripts')
</body>

</html>
