<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('header-before-body')

</head>
<body>

    @stack('header-after-body')

    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}">
                    @if ( $logo )
                        <img src="{{ $logo }}" alt="{{ config('app.name') }}" width="50" class="img-fluid mr-2">
                    @endif
                    <span class="text-primary">{{ config('app.name', 'Clinic') }}</span>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-2">
                        <ul class="admin-side-menu">
                            <li><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
                            @if ( Auth::user()->isRole('doctor') )
                                <li><a href="{{ route('checkup.index') }}">{{ __('Checkup') }}</a></li>
                            @else
                                <li>
                                    <a href="{{ route('patient.index') }}">{{ __('Patient') }}</a>
                                    <ul>
                                        <li><a href="{{ route('checkup.index') }}">{{ __('Checkup List') }}</a></li>
                                        <li><a href="{{ route('patient.index') }}">{{ __('Patient List') }}</a></li>
                                        {{-- <li><a href="{{ route('patient.create') }}">{{ __('Add Patient') }}</a></li> --}}
                                    </ul>
                                </li>
                            @endif
                            @if ( Auth::user()->isRole('doctor') )
                                <li><a href="{{ route('schedule.index', Auth::user()->doctor->id) }}">{{ __('Set Schedule') }}</a></li>
                                <li><a href="{{ route('doctor.edit', Auth::user()->doctor->id) }}">{{ __('Doctor Data') }}</a></li>
                                <li><a href="{{ route('user.edit', Auth::id()) }}">{{ __('Account') }}</a></li>
                            @else
                                <li>
                                    <a href="{{ route('doctor.index') }}">{{ __('Doctor') }}</a>
                                    <ul>
                                        <li><a href="{{ route('doctor.index') }}">{{ __('Doctor List') }}</a></li>
                                        <li><a href="{{ route('doctor.create') }}">{{ __('Add Doctor') }}</a></li>
                                        <li><a href="{{ route('polyclinic.index') }}">{{ __('Polyclinics') }}</a></li>
                                        {{-- <li><a href="{{ route('qualification.index') }}">{{ __('Qualification') }}</a></li> --}}
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('user.index') }}">{{ __('User') }}</a>
                                    <ul>
                                        <li><a href="{{ route('user.index') }}">{{ __('User List') }}</a></li>
                                        <li><a href="{{ route('user.create') }}">{{ __('Add User') }}</a></li>
                                        <li><a href="{{ route('role.index') }}">{{ __('Role') }}</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('setting.index') }}">{{ __('Setting') }}</a></li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-md">
                        @yield('content')
                    </div>
                </div>
            </div>
        </main>
    </div>

    @stack('footer-before-script')

    <script src="{{ asset('js/app.js') }}"></script>

    @stack('footer-after-script')

</body>
</html>
