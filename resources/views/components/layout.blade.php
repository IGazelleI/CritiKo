<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" href="images/favicon.ico" />
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />
        <script src="//unpkg.com/alpinejs" defer></script>
        <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.js"></script>
        @vite('resources/css/app.css')
        <script src="./TW-ELEMENTS-PATH/dist/js/index.min.js"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            laravel: "#ef3b2d",
                        },
                    },
                },
            };
        </script>
        <title>CritiKo</title>
    </head>
    <body class="bg-gradient-to-l from-slate-100 to-slate-300 w-full h-full">
        <nav class="flex justify-between items-center mb-4">
            <a href="/"
                ><img class="h-12 inline" src="" alt="Logo" class="logo"
            /></a>
            <ul class="flex space-x-6 mr-6 text-lg">
                @auth
                    @if(auth()->user()->type == 'admin')
                    <li>
                        <a href="/user/manage" class="bg-blue hover:text-laravel"></i> User </a>
                    </li>
                    <li>
                        <a href="/period/manage" class="bg-blue hover:text-laravel"></i> Period </a>
                    </li>
                    <li>
                        <a href="/department/manage" class="bg-blue hover:text-laravel"></i> Department </a>
                    </li>
                    <li>
                        <a href="/course" class="hover:text-laravel"></i> Course </a>
                    </li>
                    <li>
                        <a href="/subject" class="hover:text-laravel"></i> Subject </a>
                    </li>
                    <li>
                        <a href="/block" class="hover:text-laravel"></i> Block </a>
                    </li>
                    <li>
                        <a href="/register" class="hover:text-laravel"><i class="fa-solid fa-user-plus"></i> Register</a>
                    </li>
                    @elseif(auth()->user()->type == 'sast')
                    <li>
                        <a href="/question" class="bg-blue hover:text-laravel"></i> Question </a>
                    </li>
                    @elseif(auth()->user()->type == 'student' || auth()->user()->type == 'faculty')
                    @if(auth()->user()->type == 'student')
                    <li>
                        <a href="/enroll" class="bg-blue hover:text-laravel"
                            ></i> Enroll </a
                        >
                    </li>
                    @elseif(auth()->user()->isDean())
                    <li>
                        <a href="/enrollments" class="bg-blue hover:text-laravel"></i> Enrollments </a>
                    </li>
                    @endif
                    <li>
                        <a href="/{{auth()->user()->type}}/evaluate" class="bg-blue hover:text-laravel"></i> Evaluate </a>
                    </li>
                    @endif
                    <li>
                        <span class="font-bold">
                            {{auth()->user()->name}}
                        </span>
                    </li>
                    <li>
                        <form action="/logout" method="POST" class="inline">
                            @csrf

                            <button type="submit">
                                <i class="fa-solid fa-door-closed"></i>   Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li>
                        <a href="/login" class="hover:text-laravel"><i class="fa-solid fa-arrow-right-to-bracket"></i>
                            Login
                        </a>
                    </li>
                @endauth
            </ul>
        </nav>
        <main>
            {{$slot}}
        </main>
        <x-flash-message/>
        <x-footer/>
    </body>
</html>