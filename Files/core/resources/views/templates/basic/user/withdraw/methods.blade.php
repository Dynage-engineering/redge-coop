@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card custom--card">
                    <div class="card-body">
                        <form action="{{ route('user.withdraw.apply') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>@lang('Method')</label>
                                <select class="form--control" name="method_code" required>
                                    <option value="">@lang('Select Gateway')</option>
                                    @foreach ($withdrawMethod as $data)
                                        <option value="{{ $data->id }}" data-resource="{{ $data }}"> {{ __($data->name) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label>@lang('Amount')</label>
                                <div class="input-group">
                                    <input type="number" step="any" name="amount" value="{{ old('amount') }}" class="form--control" required>
                                    <span class="input-group-text">{{ $general->cur_text }}</span>
                                </div>
                            </div>

                            @include($activeTemplate . 'partials.otp_field')

                            <div class="mt-3">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="text-muted">@lang('Limit')</span>
                                        <span><span class="min">0</span> {{ __($general->cur_text) }} - <span class="max">0</span> {{ __($general->cur_text) }}</span>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="text-muted">@lang('Charge')</span>
                                        <span><span class="charge">0</span> {{ __($general->cur_text) }}</span>
                                    </li>

                                    <li class="list-group-item d-flex justify-content-between">
                                        <span class="text-muted">@lang('Receivable')</span> <span><span class="receivable"> 0</span> {{ __($general->cur_text) }} </span>
                                    </li>

                                    <li class="list-group-item d-none justify-content-between rate-element"></li>

                                    <li class="list-group-item d-none justify-content-between in-site-cur">
                                        <span class="text-muted">@lang('In') <span class="base-currency"></span></span>
                                        <strong class="final_amo">0</strong>
                                    </li>
                                </ul>
                            </div>
                            <button type="submit" class="btn btn-md btn--base w-100 mt-3">@lang('Submit')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('select[name=method_code]').on('change', function() {

                if (!$('select[name=method_code]').val()) {
                    return false;
                }

                let resource = $('select[name=method_code] option:selected').data('resource');
                let fixed_charge = parseFloat(resource.fixed_charge);
                let percent_charge = parseFloat(resource.percent_charge);
                let rate = parseFloat(resource.rate)
                let toFixedDigit = 2;

                $('.min').text(parseFloat(resource.min_limit).toFixed(2));
                $('.max').text(parseFloat(resource.max_limit).toFixed(2));

                let amount = parseFloat($('input[name=amount]').val());

                if (!amount) {
                    amount = 0;
                }
                if (amount <= 0) {
                    return false;
                }

                let charge = parseFloat(fixed_charge + (amount * percent_charge / 100)).toFixed(2);
                $('.charge').text(charge);
                if (resource.currency != '{{ $general->cur_text }}') {
                    let rateElement = `<span>@lang('Conversion Rate')</span> <span>1 {{ __($general->cur_text) }} = <span class="rate">${rate}</span>  <span class="base-currency">${resource.currency}</span></span>`;
                    $('.rate-element').html(rateElement);
                    $('.rate-element').removeClass('d-none');
                    $('.in-site-cur').removeClass('d-none');
                    $('.rate-element').addClass('d-flex');
                    $('.in-site-cur').addClass('d-flex');
                } else {
                    $('.rate-element').html('')
                    $('.rate-element').addClass('d-none');
                    $('.in-site-cur').addClass('d-none');
                    $('.rate-element').removeClass('d-flex');
                    $('.in-site-cur').removeClass('d-flex');
                }
                let receivable = parseFloat((parseFloat(amount) - parseFloat(charge))).toFixed(2);
                $('.receivable').text(receivable);
                let final_amo = parseFloat(parseFloat(receivable) * rate).toFixed(toFixedDigit);
                $('.final_amo').text(final_amo);
                $('.base-currency').text(resource.currency);
                $('.method_currency').text(resource.currency);
                $('input[name=amount]').on('input');
            });
            $('input[name=amount]').on('input', function() {
                let data = $('select[name=method_code]').change();
                $('.amount').text(parseFloat($(this).val()).toFixed(2));
            });

        })(jQuery);
    </script>
@endpush
