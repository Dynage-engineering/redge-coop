@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section class="pt-80 pb-80">
        <div class="container">
            <div class="row justify-content-center gy-4">
                @php
                    echo @$policy->data_values->content;
                @endphp
            </div>
        </div>
    </section>
@endsection
