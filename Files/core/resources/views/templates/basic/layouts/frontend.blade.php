@extends($activeTemplate . 'layouts.app')
@section('main-content')
    @include($activeTemplate . 'partials.header')
    <div class="main-wrapper">
        @include($activeTemplate . 'partials.breadcumb')
        @yield('content')
        @include($activeTemplate . 'partials.footer')
    </div>
@endsection
