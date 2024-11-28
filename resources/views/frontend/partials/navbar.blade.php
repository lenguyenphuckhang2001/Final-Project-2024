<!-----------Top Bar---------->
<section id="wsus__topbar">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-md-7 d-none d-md-block">
                <ul class="wsus__topbar_left">
                    <li>
                        <a href="mailto:{{ config('settings.site_email') }}">
                            <i class="fal fa-envelope"></i>
                            {{ config('settings.site_email') }}
                        </a>
                    </li>
                    <li><a href="callto:{{ config('settings.site_phonenumber') }}">
                            <i class="fal fa-phone-alt"></i>
                            {{ config('settings.site_phonenumber') }}
                        </a>
                    </li>
                </ul>
            </div>
            @auth
                <div class="col-xl-6 col-md-5">
                    <div class="wsus__topbar_right">
                        <a href="{{ route('user.dashboard') }}">
                            Hello, {{ auth()->user()->name }}
                        </a>
                    </div>
                </div>
            @endauth
            @guest()
                <div class="col-xl-6 col-md-5">
                    <div class="wsus__topbar_right">
                        <a href="{{ route('login') }}"><i class="fas fa-user"></i> Login</a>
                    </div>
                </div>
            @endguest
        </div>
    </div>
</section>

<!-----------Menu---------->
<nav class="navbar navbar-expand-lg main_menu">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset(config('settings.logo_image')) }}" style="width: 100px !important" alt="logo website">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="far fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav m-auto">
                @foreach (Menu::getByName('Menu') as $menu)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $menu['link'] }}">{{ $menu['label'] }}
                            {!! $menu['child'] ? '<i class="far fa-chevron-down"></i>' : '' !!}</a>
                        @if ($menu['child'])
                            <ul class="menu_droapdown">
                                @foreach ($menu['child'] as $menuChild)
                                    <li><a href="{{ $menuChild['link'] }}">{{ $menuChild['label'] }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</nav>
