@extends('admin.layouts.app')
@section('panel')
    <form action="" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h6 class="card-title text-center">@lang('Basic Configuration')</h6>
            </div>

            <div class="card-body has-select2">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label> @lang('Site Title')</label>
                            <input class="form-control" name="site_name" type="text" value="{{ $general->site_name }}" required>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>@lang('Currency')</label>
                            <input class="form-control" name="cur_text" type="text" value="{{ $general->cur_text }}" required>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6">
                        <div class="form-group">
                            <label>@lang('Currency Symbol')</label>
                            <input class="form-control" name="cur_sym" type="text" value="{{ $general->cur_sym }}" required>
                        </div>
                    </div>

                    <div class="form-group col-md-4 col-sm-6">
                        <label> @lang('Timezone')</label>
                        <select class="select2-basic" name="timezone">
                            @foreach ($timezones as $timezone)
                                <option value="'{{ @$timezone }}'">{{ __($timezone) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4 col-sm-6">
                        <label> @lang('Base Color')</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 p-0">
                                <input class="form-control colorPicker" type='text' value="{{ $general->base_color }}" />
                            </span>
                            <input class="form-control colorCode" name="base_color" type="text" value="{{ $general->base_color }}" />
                        </div>
                    </div>

                    <div class="form-group col-md-4 col-sm-6">
                        <label> @lang('Secondary Color')</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 p-0">
                                <input class="form-control colorPicker" type='text' value="{{ $general->secondary_color }}" />
                            </span>
                            <input class="form-control colorCode" name="secondary_color" type="text" value="{{ $general->secondary_color }}" />
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4 col-sm-6">
                        <label>@lang('Account Number Prefix') <i class="fa fa-info-circle text--primary" title="@lang('This text will be added with every Account Number as a prefix.')"></i></label>
                        <input class="form-control" name="account_no_prefix" type="text" value="{{ $general->account_no_prefix }}">
                    </div>

                    <div class="form-group col-md-4 col-sm-6">
                        <label>@lang('Account Number Length') <i class="fa fa-info-circle text--primary" title="@lang('The number of digits for an account number without the prefix.')"></i></label>
                        <input class="form-control" name="account_no_length" type="number" value="{{ $general->account_no_length }}">
                    </div>

                    <div class="form-group col-md-4 col-sm-12">
                        <label>@lang('OTP Expiration Time') <i class="fa fa-info-circle text--primary" title="@lang('How long an OTP is valid. The Users need to verify the OTP code for any money-out transaction from this system if the OTP module is enabled.')"></i></label>
                        <div class="input-group">
                            <input class="form-control" name="otp_time" type="number" value="{{ getAmount($general->otp_time) }}">
                            <span class="input-group-text"> @lang('Seconds')</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title text-center">@lang('Transfer Limits within') {{ __($general->site_name) }}</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-sm-6 col-md-4">
                        <label>
                            @lang('Minimum Limit') <i class="fas fa-info-circle text--primary" title="@lang('For each Money Transfer within ' . $general->site_name . ', Users can\'t transfer money less than the Minimum Transfer Limit.')"></i>
                        </label>
                        <div class="input-group">
                            <input class="form-control" name="minimum_transfer_limit" type="number" value="{{ getAmount($general->minimum_transfer_limit) }}" step="any">
                            <span class="input-group-text curency-text">@lang($general->cur_text)</span>
                        </div>
                    </div>

                    <div class="form-group col-sm-6 col-md-4">
                        <label>
                            @lang('Daily Limit')
                            <i class="fas fa-info-circle text--primary" title="@lang('The maximum amount that can be transferred on a particular date.')"></i>
                        </label>
                        <div class="input-group">
                            <input class="form-control" name="daily_transfer_limit" type="number" value="{{ getAmount($general->daily_transfer_limit) }}" step="any">
                            <span class="input-group-text curency-text">@lang($general->cur_text)</span>
                        </div>
                    </div>
                    <div class="form-group col-sm-12 col-md-4">
                        <label>
                            @lang('Monthly Limit')
                            <i class="fas fa-info-circle text--primary" title="@lang('The maximum amount that can be transferred on a particular month.')"></i>
                        </label>
                        <div class="input-group">
                            <input class="form-control" name="monthly_transfer_limit" type="number" value="{{ getAmount($general->monthly_transfer_limit) }}" step="any">
                            <span class="input-group-text curency-text">@lang($general->cur_text)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h6 class="card-title text-center">@lang('Transfer Charges within') {{ __($general->site_name) }}</h6>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="form-group col-sm-6">
                        <label>@lang('Fixed Charge')</label>
                        <div class="input-group">
                            <input class="form-control" name="fixed_transfer_charge" type="number" value="{{ getAmount($general->fixed_transfer_charge) }}" step="any">
                            <span class="input-group-text curency-text">@lang($general->cur_text) </span>
                        </div>
                    </div>

                    <div class="form-group col-sm-6">
                        <label>@lang('Percent Charge')</label>
                        <div class="input-group">
                            <input class="form-control" name="percent_transfer_charge" type="number" value="{{ getAmount($general->percent_transfer_charge) }}" step="any">
                            <span class="input-group-text curency-text">%</span>
                        </div>
                    </div>
                </div>

                <small>
                    <i class="la la-info-circle text--primary"></i>
                    <i class="text-muted">@lang('Fixed + Percent charge amount will be applied on each transfer within') {{ __($general->site_name) }}</i>
                </small>
            </div>
        </div>

        <button class="btn btn--primary w-100 h-45 mt-3" type="submit">@lang('Submit')</button>
    </form>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/admin/css/spectrum.css') }}" rel="stylesheet">
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.colorPicker').spectrum({
                color: $(this).data('color'),
                change: function(color) {
                    $(this).parent().siblings('.colorCode').val(color.toHexString().replace(/^#?/, ''));
                }
            });

            $('.colorCode').on('input', function() {
                var clr = $(this).val();
                $(this).parents('.input-group').find('.colorPicker').spectrum({
                    color: clr,
                });
            });

            $('select[name=timezone]').val("'{{ config('app.timezone') }}'").select2();
            $('.select2-basic').select2({
                dropdownParent: $('.card-body.has-select2')
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .select2-container {
            z-index: 99 !important;
        }
    </style>
@endpush
