@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card custom--card">

                    <div class="card-body">
                        <form class="register" action="" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="currentPassword">@lang('Current Password')</label>
                                <div class="input-group">
                                    <input class="form--control" id="currentPassword" name="current_password" type="password" placeholder="Current Password" required autocomplete="current-password">
                                    <span class="input-group-text"><i class="las la-user-lock"></i></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">@lang('Password')</label>
                                <div class="input-group hover-input-popup">
                                    <input class="form--control" id="password" name="password" type="password" placeholder="New Password" required autocomplete="current-password">
                                    <span class="input-group-text"><i class="la la-key"></i></span>
                                    @if ($general->secure_password)
                                        <div class="input-popup">
                                            <p class="text-danger capital my-1"><small>@lang('Minimum 1 capital letter is required')</small></p>
                                            <p class="text-danger lower my-1"><small>@lang('Minimum 1 small letter is required')</small></p>
                                            <p class="text-danger number my-1"><small>@lang('Minimum 1 number is required')</small></p>
                                            <p class="text-danger special my-1"><small>@lang('Minimum 1 special character is required')</small></p>
                                            <p class="text-danger minimum my-1"><small>@lang('Minimum 6 characters')</small></p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">@lang('Confirm Password')</label>
                                <div class="input-group">
                                    <input id="password_confirmation" placeholder="Confirm Password" type="password" class="form--control name="password_confirmation" required autocomplete="current-password">
                                    <span class="input-group-text"><i class="la la-key"></i></span>
                                </div>
                            </div>
                            <input class="btn btn--base w-100" type="submit" value="@lang('Change Password')">
                        </form>
                    </div>
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

@push('bottom-menu')
    <li><a href="{{ route('user.profile.setting') }}">@lang('Profile')</a></li>
    <li><a href="{{ route('user.referral.users') }}">@lang('Referral')</a></li>
    <li><a href="{{ route('user.twofactor') }}">@lang('2FA Security')</a></li>
    <li><a class="active" href="{{ route('user.change.password') }}">@lang('Change Password')</a></li>
    <li><a href="{{ route('user.transaction.history') }}">@lang('Transactions')</a></li>
    <li><a class="{{ menuActive(['ticket.*']) }}" href="{{ route('ticket.index') }}">@lang('Support Tickets')</a></li>
@endpush
