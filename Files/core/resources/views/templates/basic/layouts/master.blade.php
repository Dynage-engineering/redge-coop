@extends($activeTemplate . 'layouts.app')
@section('main-content')
    @include($activeTemplate . 'partials.header')
    <div class="main-wrapper">
        @include($activeTemplate . 'partials.breadcumb')
        @include($activeTemplate . 'partials.bottom_menu')
        <section class="pt-80 pb-80 bg_img" style="background-image: url(' {{ asset($activeTemplateTrue . 'images/elements/bg1.jpg') }} ');">
            @yield('content')
        </section>
        @include($activeTemplate . 'partials.footer')
    </div>
@endsection
