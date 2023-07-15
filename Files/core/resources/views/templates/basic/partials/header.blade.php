<header class="header">
    <div class="header__bottom">
        <div class="container">
            <nav class="navbar navbar-expand-lg align-items-center justify-content-between p-0">
                <a class="site-logo site-title" href="{{ route('home') }}">
                    <img src="{{ getImage('assets/images/logoIcon/logo.png') }}" alt="logo">
                </a>
                <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" type="button" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="menu-toggle"></span>
                </button>
                <div class="collapse navbar-collapse mt-xl-0 mt-3" id="navbarSupportedContent">

                    <ul class="navbar-nav main-menu m-auto" id="linkItem">
                        @if (auth()->user() && request()->routeIs('ticket*'))
                            @include($activeTemplate . 'partials.auth_header')
                        @elseif (!request()->routeIs('user.*') || !auth()->user())
                            @include($activeTemplate . 'partials.guest_header')
                        @else
                            @include($activeTemplate . 'partials.auth_header')
                        @endif
                    </ul>

                    <div class="nav-right">
                        @if ($language->count() > 1)
                            <select class="language-select me-3 langSel">
                                @foreach ($language as $item)
                                    <option value="{{ $item->code }}" @if (session('lang') == $item->code) selected @endif>{{ __($item->name) }}</option>
                                @endforeach
                            </select>
                        @endif

                        @if (auth()->user() && !request()->routeIs('user.*'))
                            <a class="btn btn-sm btn-outline--gradient me-3 py-2" href="{{ route('user.home') }}">@lang('Dashboard')</a>
                        @endif

                        @guest
                            <a class="btn btn-sm btn-outline--gradient me-3 py-2" href="{{ route('user.login') }}">@lang('Sign In')</a>
                            <a class="btn btn-sm custom--bg py-2 text-white" href="{{ route('user.register') }}">@lang('Sign Up')</a>
                        @else
                            <a class="btn btn-sm custom--bg py-2 text-white" href="{{ route('user.logout') }}">@lang('Logout')</a>
                        @endguest
                    </div>
                </div>
            </nav>
        </div>
    </div>
</header>
