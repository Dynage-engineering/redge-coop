@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="" method="post">
                    @csrf
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item d-flex flex-sm-nowrap justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <p class="fw-bold mb-0">@lang('Online User Registration')</p>
                                    <p class="mb-0">
                                        <small>@lang('If this module is disabled, none can get registered on this system online.')</small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input name="registration" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($general->registration) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="form-control-label fw-bold">@lang('Branch User Registration')</p>
                                    <p class="mb-0">
                                        @lang('If this module is disabled, none can get registered on this system from a branch.')
                                    </p>
                                </div>

                                <div class="form-group">
                                    <input name="module[branch_create_user]" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($modules && @$modules->branch_create_user) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex flex-sm-nowrap justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <p class="fw-bold mb-0">@lang('Force SSL')</p>
                                    <p class="mb-0">
                                        <small>@lang('By enabling') <span class="fw-bold">@lang('Force SSL (Secure Sockets Layer)')</span> @lang('the system will force a visitor that he/she must have to visit in secure mode. Otherwise, the site will be loaded in secure mode.')</small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input name="force_ssl" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($general->force_ssl) checked @endif>
                                </div>
                            </li>
                            <li class="list-group-item d-flex flex-sm-nowrap justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <p class="fw-bold mb-0">@lang('Agree Policy')</p>
                                    <p class="mb-0">
                                        <small>@lang('If you enable this module, that means a user must have to agree with your system\'s') <a href="{{ route('admin.frontend.sections', 'policy_pages') }}">@lang('policies')</a> @lang('during registration.')</small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input name="agree" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($general->agree) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex flex-sm-nowrap justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <p class="fw-bold mb-0">@lang('Force Secure Password')</p>
                                    <p class="mb-0">
                                        <small>@lang('By enabling this module, a user must set a secure password while signing up or changing the password.')</small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input name="secure_password" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($general->secure_password) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex flex-sm-nowrap justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <p class="fw-bold mb-0">@lang('KYC Verification')</p>
                                    <p class="mb-0">
                                        <small>@lang('If you enable') <span class="fw-bold">@lang('KYC (Know Your Client)')</span> @lang('module, users must have to submit') <a href="{{ route('admin.kyc.setting') }}">@lang('the required data')</a>. @lang('Otherwise, any money out transaction will be prevented by this system.')</small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input name="kv" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($general->kv) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex flex-sm-nowrap justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <p class="fw-bold mb-0">@lang('Email Verification')</p>
                                    <p class="mb-0">
                                        <small>
                                            @lang('If you enable') <span class="fw-bold">@lang('Email Verification')</span>, @lang('users have to verify their email to access the dashboard. A 6-digit verification code will be sent to their email to be verified.')
                                            <br>
                                            <span class="fw-bold"><i>@lang('Note'):</i></span> <i>@lang('Make sure that the') <span class="fw-bold">@lang('Email Notification') </span> @lang('module is enabled')</i>
                                        </small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input name="ev" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($general->ev) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex flex-sm-nowrap justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <p class="fw-bold mb-0">@lang('Email Notification')</p>
                                    <p class="mb-0">
                                        <small>@lang('If you enable this module, the system will send emails to users where needed. Otherwise, no email will be sent.') <code>@lang('So be sure before disabling this module that, the system doesn\'t need to send any emails.')</code></small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input name="en" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($general->en) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex flex-sm-nowrap justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <p class="fw-bold mb-0">@lang('Mobile Verification')</p>
                                    <p class="mb-0">
                                        <small>
                                            @lang('If you enable') <span class="fw-bold">@lang('Mobile Verification')</span>, @lang('users have to verify their mobile to access the dashboard. A 6-digit verification code will be sent to their mobile to be verified.')
                                            <br>
                                            <span class="fw-bold"><i>@lang('Note'):</i></span> <i>@lang('Make sure that the') <span class="fw-bold">@lang('SMS Notification') </span> @lang('module is enabled')</i>
                                        </small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input name="sv" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($general->sv) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex flex-sm-nowrap justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <p class="fw-bold mb-0">@lang('SMS Notification')</p>
                                    <p class="mb-0">
                                        <small>@lang('If you enable this module, the system will send SMS to users where needed. Otherwise, no SMS will be sent.') <code>@lang('So be sure before disabling this module that, the system doesn\'t need to send any SMS.')</code></small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input name="sn" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($general->sn) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="fw-bold">@lang('Deposit')</p>
                                    <p class="mb-0">
                                        <small>@lang("Here you can enable/disable the deposit module. After disabling this module user can't deposit money on your system.")</small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input name="module[deposit]" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($modules && $modules->deposit) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="form-control-label fw-bold">@lang('Withdraw')</p>
                                    <p class="mb-0">
                                        @lang("Here you can enable/disable the withdraw module. After disabling this module user can't withdraw money from your system.")
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input name="module[withdraw]" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($modules && $modules->withdraw) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="form-control-label fw-bold">@lang('FDR')</p>
                                    <p class="mb-0">
                                        @lang("Here you can enable/disable the FDR module. After disabling this module user can't FDR on your system.")
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input name="module[fdr]" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($modules && $modules->fdr) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="form-control-label fw-bold">@lang('DPS')</p>
                                    <p class="mb-0">
                                        @lang("Here you can enable/disable the DPS module. After disabling this module user can't DPS on your system.")
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input name="module[dps]" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($modules && $modules->dps) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="form-control-label fw-bold">@lang('Loan')</p>
                                    <p class="mb-0">
                                        @lang("Here you can enable/disable the Loan module. After disabling this module user can't apply for Loan on your system.")
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input name="module[loan]" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($modules && $modules->loan) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="form-control-label fw-bold">@lang('Own Bank Transfer')</p>
                                    <p class="mb-0">
                                        @lang("Here you can enable/disable the Own Bank Transfer Module. After disabling this module user can't transfer money within ") <b>{{ __($general->site_name) }}</b> @lang('accounts.')
                                    </p>
                                </div>

                                <div class="form-group">
                                    <input name="module[own_bank]" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($modules && $modules->own_bank) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="form-control-label fw-bold">@lang('Other Bank Transfer')</p>
                                    <p class="mb-0">@lang("Here you can enable/disable the Other Bank Transfer Module. After disabling this module user can't transfer money to other local banks").
                                    </p>
                                </div>

                                <div class="form-group">
                                    <input name="module[other_bank]" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($modules && $modules->other_bank) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="form-control-label fw-bold">@lang('Wire Transfer')</p>
                                    <p class="mb-0">
                                        @lang('Here you can enable/disable the Wire Transfer Module. After enable this module user send money to ') <b>@lang('any ohter Bank or Country')</b>
                                    </p>
                                </div>

                                <div class="form-group">
                                    <input name="module[wire_transfer]" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($modules && @$modules->wire_transfer) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="form-control-label fw-bold">@lang('OTP Via Email')</p>
                                    <p class="mb-0">@lang('Control send OTP to the user via ') <b>@lang('Email')</b> @lang('from here.')</p>
                                </div>

                                <div class="form-group">
                                    <input name="module[otp_email]" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($modules && $modules->otp_email) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="form-control-label fw-bold">@lang('OTP Via SMS')</p>
                                    <p class="mb-0">@lang('Control send OTP to the user via ') <b>@lang('SMS')</b> @lang('from here.')</p>
                                </div>
                                <div class="form-group">
                                    <input name="module[otp_sms]" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($modules && $modules->otp_sms) checked @endif>
                                </div>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="form-control-label fw-bold">@lang('Referral System')</p>
                                    <p class="mb-0">
                                        @lang('Here you can enable/disable the Referral module. After disabling this module Reffer system can\'t work on your system.')
                                    </p>
                                </div>

                                <div class="form-group">
                                    <input name="module[referral_system]" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($modules && @$modules->referral_system) checked @endif>
                                </div>
                            </li>
                            <li class="list-group-item d-flex flex-sm-nowrap justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <p class="fw-bold mb-0">@lang('Push Notification')</p>
                                    <p class="mb-0">
                                        <small>@lang('If you enable this module, the system will send Push Notification to users where needed. Otherwise, no Push Notification will be sent.') </small>
                                    </p>
                                </div>
                                <div class="form-group">
                                    <input name="pn" data-width="100%" data-size="large" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-height="35" data-on="@lang('Enable')" data-off="@lang('Disable')" type="checkbox" @if ($general->pn) checked @endif>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .toggle.btn-lg {
            height: 37px !important;
            min-height: 37px !important;
        }

        .toggle-handle {
            width: 25px !important;
            padding: 0;
        }

        .form-group {
            width: 125px;
            margin-bottom: 0;
            flex-shrink: 0
        }
    </style>
@endpush
