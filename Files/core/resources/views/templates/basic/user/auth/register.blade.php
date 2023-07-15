@extends($activeTemplate . 'layouts.app')
@section('main-content')
    @php
        $policyPages = getContent('policy_pages.element', false, null, true);
        $signupBg = getContent('signup_bg.content', true);
    @endphp

    <section class="account-section registration-section bg_img" style="background-image: url(' {{ getImage('assets/images/frontend/signup_bg/' . @$signupBg->data_values->image, '1920x1280') }}');">
        <div class="account-section-left">
            <div class="account-section-left-inner d-none d-sm-block">
                <h4 class="title text-white mb-2">{{ __(@$signupBg->data_values->heading) }}</h4>
                <p class="text-white">{{ __(@$signupBg->data_values->subheading) }}</p>
                <a href="{{ route('home') }}" class="btn btn-sm btn-outline--base mt-3"> <i class="la la-reply" aria-hidden="true"></i> @lang('Back to Home')</a>
            </div>
        </div>
        <div class="account-section-right">
            <div class="top text-center mb-5">
                <a href="{{ route('home') }}" class="account-logo">
                    <img src="{{ getImage('assets/images/logoIcon/logo.png') }}" alt="logo">
                </a>
            </div>
            <div class="middle">
                <form action="{{ route('user.register') }}" method="POST" class="verify-gcaptcha account-form">
                    @csrf
                    <div class="row">
                        @if (session()->get('reference') != null && $general->modules->referral_system)
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="referenceBy" class="form-label label">@lang('Referred by')</label>
                                    <input type="text" name="referBy" id="referenceBy" class="form--control" value="{{ session()->get('reference') }}" readonly>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">@lang('Username')</label>
                                <input type="text" class="form--control checkUser" name="username" value="{{ old('username') }}" required>
                                <small class="text-danger usernameExist"></small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">@lang('E-Mail Address')</label>
                                <input type="email" class="form--control checkUser" name="email" value="{{ old('email') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">@lang('Country')</label>
                                <select name="country" class="form--control">
                                    @foreach ($countries as $key => $country)
                                        <option data-mobile_code="{{ $country->dial_code }}" value="{{ $country->country }}" data-code="{{ $key }}">
                                            {{ __($country->country) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">@lang('Mobile')</label>
                                <div class="input-group ">
                                    <span class="input-group-text mobile-code text-white"></span>
                                    <input type="number" name="mobile" value="{{ old('mobile') }}" class="form--control checkUser" required>
                                </div>
                                <small class="text-danger mobileExist"></small>
                            </div>
                            <input type="hidden" name="mobile_code">
                            <input type="hidden" name="country_code">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">@lang('Password')</label>
                                <input type="password" class="form--control" name="password" required>
                                @if ($general->secure_password)
                                    <div class="input-popup">
                                        <p class="error lower">@lang('1 small letter minimum')</p>
                                        <p class="error capital">@lang('1 capital letter minimum')</p>
                                        <p class="error number">@lang('1 number minimum')</p>
                                        <p class="error special">@lang('1 special character minimum')</p>
                                        <p class="error minimum">@lang('6 character password')</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label required">@lang('Confirm Password')</label>
                                <input type="password" class="form--control" name="password_confirmation" required>
                            </div>
                        </div>
                        <x-captcha />
                    </div>
                    @if ($general->agree)
                        <div class="form-group">
                            <input type="checkbox" id="agree" @checked(old('agree')) name="agree" required>
                            <label for="agree">@lang('I agree with')</label>
                            <span>
                                @foreach ($policyPages as $policy)
                                    <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}">{{ __($policy->data_values->title) }}</a>
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </span>
                        </div>
                    @endif

                    <button type="submit" id="recaptcha" class="btn btn--base w-100"> @lang('Register')</button>

                </form>

                <p class="mt-3 text-white">@lang('Already haver an account?')
                    <a href="{{ route('user.login') }}" class="text--base">@lang('Login Now')</a>
                </p>
            </div>
        </div>
    </section>

    <div class="modal fade" id="existModalCenter" tabindex="-1" role="dialog" aria-labelledby="existModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="existModalLongTitle">@lang('You are with us')</h5>
                    <span type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <h6 class="text-center">@lang('You already have an account please Login ')</h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">@lang('Close')</button>
                    <a href="{{ route('user.login') }}" class="btn btn--base btn-sm">@lang('Login')</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@if ($general->secure_password)
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('script')
    <script>
        "use strict";
        (function($) {

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));
            });

            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobile-code').text('+' + $('select[name=country] :selected').data('mobile_code'));

            @if ($mobileCode)
                $(`option[data-code={{ $mobileCode }}]`).attr('selected', '');
            @endif

            $('.checkUser').on('focusout', function(e) {

                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';

                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    };
                }

                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }

                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }

                $.post(url, data, function(response) {
                    if (response.data != false && response.type == 'email') {
                        $('#existModalCenter').modal('show');
                    } else if (response.data != false) {
                        $(`.${response.type}Exist`).text(`This ${response.type} is already exist`);
                    } else {
                        $(`.${response.type}Exist`).empty();
                    }
                });
            });

        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .country-code .input-group-text {
            background: #fff !important;
        }

        .country-code select {
            border: none;
        }

        .country-code select:focus {
            border: none;
            outline: none;
        }

        .input-popup {
            bottom: 80% !important;
        }
    </style>
@endpush
