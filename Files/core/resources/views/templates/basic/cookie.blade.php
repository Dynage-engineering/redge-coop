@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @dd($cookie);
    <section class="pt-80 pb-80">
        <div class="container">
            <div class="row justify-content-center">
                @php
                    echo $cookie->data_values->description;
                @endphp
            </div>
        </div>
    </section>
@endsection
