<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if(View::hasSection('title'))
            @yield('title')
        @else
            {{ __('Admin Panel') }}
        @endif
    </title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    @stack('style')

    @include('layouts.snippet', ['snippets' => $headerSnippets])
</head>
<body>

@include('layouts.noscript')

    <div id="app" class="wrapper">
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3><a href="{{ route('admin.index') }}"> {{ __('ADMIN PANEL') }}</a></h3>
            </div>

            <ul class="list-unstyled components">
                @userCan('user.index')
                    <li>
                        <a href="{{ route('admin.user.index') }}">@lang('menu.menu_admin.users')</a>
                    </li>
                @endUserCan

                @userCan('setting.index')
                    <li>
                        <a href="{{ route('admin.setting.index') }}">@lang('menu.menu_admin.settings')</a>
                    </li>
                @endUserCan

                @userCan('menu.index')
                    <li>
                        <a href="{{ route('admin.menu.index') }}">@lang('menu.menu_admin.menu')</a>
                    </li>
                @endUserCan

                @userCan('snippet.index')
                    <li>
                        <a href="{{ route('admin.snippet.index') }}">@lang('menu.menu_admin.snippets')</a>
                    </li>
                @endUserCan

                @foreach($packages as $item)
                    @userCan($item['menu']['permission'])
                        <li>
                            <a href="{{ route($item['menu']['route']) }}">@lang($item['menu']['title'])</a>
                        </li>
                    @endUserCan
                @endforeach

                @stack('menu')
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">

                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                    <button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item active">
                                <a class="nav-link" href="/logout">{{ __('Logout') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            @include('layouts.session-message')

            @yield('content')
        </div>
    </div>

    <script type="text/javascript">
        window.onload = function() {
            if (window.jQuery) {
                $('#sidebarCollapse').on('click', function () {
                    $('#sidebar').toggleClass('active');
                });
            }
        };
    </script>
    @stack('scripts')

@include('layouts.snippet', ['snippets' => $footerSnippets])
</body>
</html>
