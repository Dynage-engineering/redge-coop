@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card custom--card">
                    <div class="card-header bg-white">
                        <h5 class="card-title text-center">@lang('Deposit via') {{ __($deposit->gateway->name) }}</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ $data->url }}" method="{{ $data->method }}">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">@lang('You have to pay ')</span>
                                    <span>{{ showAmount($deposit->final_amo) }} {{ __($deposit->method_currency) }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted">@lang('You will get ')</span>
                                    <span>{{ showAmount($deposit->amount) }} {{ __($general->cur_text) }}</span>
                                </li>
                            </ul>
                            <script src="{{ $data->src }}" class="stripe-button" @foreach ($data->val as $key => $value)
                            data-{{ $key }}="{{ $value }}" @endforeach></script>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .h-45 {
            height: 45px;
        }
    </style>
@endpush
@push('script')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        (function($) {
            "use strict";
            $('button[type="submit"]').addClass("btn btn--base h-45 w-100 mt-3");
            $('button[type="submit"]').text("Pay Now");
        })(jQuery);
    </script>
@endpush
