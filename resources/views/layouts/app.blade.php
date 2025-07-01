<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ceresyo') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!--  Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon-new.ico') }}">
</head>

<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100 flex flex-col">

        <!-- Navbar / navigation -->
        @include('layouts.navigation')

        <!-- Botón para mostrar/ocultar el menú en pantallas pequeñas -->
        <div class="p-2 bg-white shadow md:hidden">
            <button @click="sidebarOpen = !sidebarOpen" class="text-green-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <div class="flex flex-1">
            <!-- Sidebar -->
            <!-- Modo responsive: visible solo cuando sidebarOpen = true -->
            <aside x-show="sidebarOpen" x-transition:enter="transition transform ease-out duration-300"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition transform ease-in duration-300" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full" @click.away="sidebarOpen = false"
                class="fixed inset-y-0 left-0 z-50 w-64 bg-green-100  p-4 space-y-4 md:hidden"
                style="display: none;">
                <div class="p-4 font-bold text-xl border-b border-green-100">Menú</div>
                <nav>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('profile.edit') }}"
                                class=" font-semibold text-green-700 block py-2 px-4 hover:bg-green-700 rounded ">Editar mis datos</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard') }}" class="block py-2 px-4 hover:bg-gray-700 rounded font-semibold text-green-700">Generar
                                cerftificado</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard') }}"
                                class="block py-2 px-4 hover:bg-green-700 rounded font-semibold text-green-700">Configuración</a>
                        </li>
                    </ul>
                </nav>
            </aside>

            <!-- Sidebar en pantallas grandes (md:block) -->
            <aside class="hidden md:block w-64 bg-gray-100 text-green-700 p-4 space-y-4 ">
                <div class="bg-white p-4 font-bold text-xl border-b border-red-100">Menú</div>
                <nav>
                    <ul class="space-y-2">
                        <li>
                            
                                <a href="{{ route('profile.edit') }}"
                                class="bg-white text-green-700 flex items-center gap-2 py-2 px-4 hover:bg-green-600 hover:text-white rounded transition-colors border border-yellow-500 group">
                                    <!-- <svg class="h-6 w-6 text-green-600 group-hover:text-white transition-colors"
                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5.121 17.804A13.937 13.937 0 0112 15c2.166 0 4.215.516 6.121 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg> -->
                                    <span>Editar mis datos</span>
                                </a>
                           
                        </li>



                        <li>
                            <a href="{{ route('certificado.generar') }}"
                                class="bg-white text-green-700 block py-2 px-4 hover:bg-green-600 hover:text-white rounded border border-yellow-500 group">Generar certificado</a>
                        </li>

                        <li>
                            <a href="{{ route('dashboard') }}"
                                class=" bg-white  text-green-700 block py-2 px-4 hover:bg-green-600 hover:text-white rounded border border-yellow-500 group">Configuración</a>
                        </li>
                    </ul>
                </nav>
            </aside>

            <!-- Contenido principal -->
            <div class="flex-1 flex flex-col ml-0 transition-all">
                @isset($header)
                    <header class="bg-white shadow">
                        <div class="max-w-7xl mx-auto py-4 px-2 sm:px-4 lg:px-4 text-center">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <main class="flex-1 p-4">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </div>
</body>

</html>
