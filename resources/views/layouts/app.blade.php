<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
     <link href="{{ asset('css/demo.css') }}" rel="stylesheet">
    <style>
        .background-image
        {
            background-image: url('https://c1.wallpaperflare.com/preview/306/717/306/editing-macbook-night-photo.jpg');
            background-position: center center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            height: 600px;
        }
        p.content{
            width: 1200px;
            margin: auto;
        }
        div.comment{
            width: 1200px;
            margin: auto;
            display: flex;
            margin-bottom: 10px;
        }
        div.comment-detail p {
            font-weight: 350;
            font-size: 14px;
            margin-top: 7px;
            line-height: 18px;
        }
        .comment-ava{
            margin-right: 10px;
        }
        span.time{
            font-size: 12px;
            margin-left: 5px;
            font-weight: 100;
        }
        a.reply {
            font-size: 12px;
            font-weight: 200;
            margin-top: 5px;
            color: #a4a09b;
        }
        .form-comment{
            width: 1200px;
            margin: auto;
        }
        .title-comment{
            width: 1200px;
            margin: auto;
            margin-bottom:3px;
            
        }
        hr{
            width: 1200px;
            margin: auto;
            margin-bottom:10px;
        }
        .submit-comment{
            border: 1px solid;
            padding: 5px;
            margin-top: 20px;
            border-radius: 5px;
            background-color: rgb(90, 128, 235);
            line-height: 20px;
            font-weight: 600;
            color: white;
        }
        .table-blog table{
            margin: auto;
            border: 1px solid;
        }
        .table-blog th{
            margin: auto;
            padding: 10px;
            width: 300px;
            border: 1px solid;
        }
        .table-blog td {
          
            line-height: 40px;
            border: 1px solid;
        }
        .table-blog td a {
            text-decoration: none;
        }
        .button:hover {
            color: red;
            text-decoration: underline;
        }
        .pagination {
            margin-left: 250px;
        }
        .pagination p{
            display: none;
        }
        .table-myblog table{
            margin: auto;
            border: 1px solid;
        }
        .table-myblog th{
            margin: auto;
            padding: 10px;
            border: 1px solid;
        }
        .table-myblog td {
            width: 220px;
            line-height: 40px;
            border: 1px solid;
        }
        .table-myblog td a:hover {
            cursor: pointer;
            color: red;
            text-decoration: underline;
        }
        .submit-form {
            border:black solid 1px;
            color: brown;
            padding: 3px;
            margin-bottom: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>
<body class="bg-gray-100 h-screen antialiased leading-none font-sans">
    <div id="app">
        <header class="bg-gray-800 py-6">
            <div class="container mx-auto flex justify-between items-center px-6">
                <div>
                    <a href="{{ url('/') }}" class="text-lg font-semibold text-gray-100 no-underline">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                <nav class="space-x-4 text-gray-300 text-sm sm:text-base">
                    @if (!empty(auth()->user()->is_admin))
                        <a class="no-underline hover:underline" href="/admin/blog">Dashboard</a>
                    @endif                    
                    <a class="no-underline hover:underline" href="/">Home</a>
                    <a class="no-underline hover:underline" href="/blog">Blog</a>
                    @guest
                        <a class="no-underline hover:underline" href="{{ route('login') }}">{{ __('Login') }}</a>
                        @if (Route::has('register'))
                            <a class="no-underline hover:underline" href="{{ route('register') }}">{{ __('Register') }}</a>
                        @endif
                    @else
                        <span>{{ Auth::user()->name }}</span>

                        <a href="{{ route('logout') }}"
                           class="no-underline hover:underline"
                           onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            {{ csrf_field() }}
                        </form>
                    @endguest
                </nav>
            </div>
        </header>

        <div>
            @yield('content')
        </div>
        <div>
            @include('layouts.footer')
        </div>
    </div>
</body>
</html>
