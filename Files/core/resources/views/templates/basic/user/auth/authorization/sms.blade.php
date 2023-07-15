@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container pt-80 pb-80">
        <div class="d-flex justify-content-center">
            <div class="verification-code-wrapper">
                <div class="verification-area">
                    <form action="{{ route('user.verify.mobile') }}" method="POST" class="submit-form">
                        @csrf
                        <p class="mb-3">@lang('A 6 digit verification code sent to your mobile number') : +{{ showMobileNumber(auth()->user()->mobile) }}</p>
                        @include($activeTemplate . 'partials.verification_code')

                        <div class="form-group">
                            <button type="submit" class="btn btn--base w-100">@lang('Submit')</button>
                        </div>

                        <p>
                            @lang('If you don\'t get any code'), <a href="{{ route('user.send.verify.code', 'phone') }}" class="forget-pass text--base"> @lang('Try again')</a>
                        </p>

                        @if ($errors->has('resend'))
                            <small class="text--danger">{{ $errors->first('resend') }}</small>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
