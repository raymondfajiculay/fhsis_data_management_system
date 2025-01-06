<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body>
    <header>
        <nav class="bg-white border-gray-200 dark:bg-gray-900">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">FHSIS</span>
                </a>
                <button data-collapse-toggle="navbar-default" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="navbar-default" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
                <div class="flex gap-2">
                    <ul
                        class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">

                        @auth
                            <li>
                                <a href="{{ route('dashboard') }}"
                                    class="block py-2 px-3 rounded md:p-0
                                    {{ Route::is('dashboard') ? 'text-blue-700 bg-gray-900' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white' }}"
                                    aria-current="page">Dashboard</a>
                            </li>
                            <li>
                                <a href="{{ route('files') }}"
                                    class="block py-2 px-3 rounded md:p-0
                                    {{ Route::is('files') ? 'text-blue-700 bg-gray-900' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                                    Files</a>
                            </li>
                            @can('upload-file')
                                <li>
                                    <a href="/file-upload"
                                        class="block py-2 px-3 rounded md:p-0
                                        {{ request()->is('file-upload') ? 'text-blue-700 bg-gray-900' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                                        Upload</a>
                                </li>
                            @endcan
                            @can('create-user')
                                <li>
                                    <a href="/register"
                                        class="block py-2 px-3 rounded md:p-0
                                        {{ request()->is('register') ? 'text-blue-700 bg-gray-900' : 'text-gray-900 hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white' }}">
                                        Users</a>
                                </li>
                            @endcan

                            <li>
                                <form action="/logout" method="POST"
                                    class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                                    @csrf
                                    <input type="submit" value="Logout">
                                </form>
                            </li>
                        @endauth
                        @guest
                            <li>
                                <a href="/login"
                                    class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Login</a>
                            </li>
                        @endguest

                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main class="p-5">
        {{ $slot }}
    </main>
</body>

</html>
