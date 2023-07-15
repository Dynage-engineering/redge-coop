@extends($activeTemplate . 'layouts.master')
@php
$kyc = getContent('kyc_content.content', true);
@endphp
@section('content')
    <div class="container">
        <div class="row justify-content-center gy-4">
            <div class="col-lg-12">
                @if ($user->kv == 0)
                    <div class="card-widget section--bg2" role="alert">
                        <h4 class="text--base">@lang('KYC Verification required')</h4>
                        <hr>
                        <p class="mb-0 text-white">{{ __(@$kyc->data_values->unverified_content) }} <a href="{{ route('user.kyc.form') }}" class="text--base">@lang('Click Here to Verify')</a></p>
                    </div>
                @elseif(auth()->user()->kv == 2)
                    <div class="card-widget section--bg2" role="alert">
                        <h4 class="text--base">@lang('KYC Verification pending')</h4>
                        <hr>
                        <p class="mb-0 text-white">{{ __(@$kyc->data_values->pending_content) }} <a href="{{ route('user.kyc.data') }}" class="text--base">@lang('See KYC Data')</a></p>
                    </div>
                @endif
            </div>
            <div class="col-lg-6">
                <div class="card-widget section--bg2 text-center bg_img" style="background-image: url(' {{ asset($activeTemplateTrue . 'images/elements/card-bg.png') }} ');">
                    <span class="caption text-white mb-3">@lang('Account Number')</span>
                    <h3 class="d-number text-white">{{ $user->account_number }}</h3>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card-widget section--bg2 text-center bg_img" style="background-image: url(' {{ asset($activeTemplateTrue . 'images/elements/card-bg.png') }} ');">
                    <span class="caption text-white mb-3">@lang('Available Balance')</span>
                    <h3 class="d-number text-white">{{ $general->cur_sym }}{{ showAmount($user->balance) }}</h3>
                </div>
            </div>

            @if (@$general->modules->deposit)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('user.deposit.history') }}" class="w-100 h-100">
                        <div class="d-widget section--bg2 d-flex flex-wrap align-items-center rounded-3 bg_img h-100" style="background-image: url(' {{ asset($activeTemplateTrue . 'images/elements/card-bg.png') }} ');">
                            <div class="d-widget__content">
                                <h3 class="d-number text-white">
                                    {{ $general->cur_sym }}{{ showAmount(@$widget['total_deposit']) }}
                                </h3>
                                <span class="caption text-white">@lang('Deposits')</span>
                            </div>
                            <div class="d-widget__icon border-radius--100">
                                <i class="las la-wallet"></i>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
            @if (@$general->modules->withdraw)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('user.withdraw.history') }}" class="w-100 h-100">
                        <div class="d-widget section--bg2 d-flex flex-wrap align-items-center rounded-3 bg_img h-100" style="background-image: url(' {{ asset($activeTemplateTrue . 'images/elements/card-bg.png') }} ');">
                            <div class="d-widget__content">
                                <h3 class="d-number text-white">{{ $general->cur_sym }}{{ showAmount(@$widget['total_withdraw']) }}</h3>
                                <span class="caption text-white">@lang('Withdrawals')</span>
                            </div>
                            <div class="d-widget__icon border-radius--100">
                                <i class="las la-money-check"></i>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
            <div class="col-lg-4 col-md-6">
                <a href="{{ route('user.transaction.history') }}" class="w-100 h-100">
                    <div class="d-widget section--bg2 d-flex flex-wrap align-items-center rounded-3 bg_img h-100" style="background-image: url(' {{ asset($activeTemplateTrue . 'images/elements/card-bg.png') }} ');">
                        <div class="d-widget__content">
                            <h3 class="d-number text-white">{{ @$widget['total_trx'] }}</h3>
                            <span class="caption text-white">@lang('Transactions')</span>
                        </div>
                        <div class="d-widget__icon border-radius--100">
                            <i class="las la-exchange-alt"></i>
                        </div>
                    </div>
                </a>
            </div>
            @if ($general->modules->fdr)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('user.fdr.list') }}" class="w-100 h-100">
                        <div class="d-widget section--bg2 d-flex flex-wrap align-items-center rounded-3 bg_img h-100" style="background-image: url(' {{ asset($activeTemplateTrue . 'images/elements/card-bg.png') }} ');">
                            <div class="d-widget__content">
                                <h3 class="d-number text-white">{{ @$widget['total_fdr'] }}</h3>
                                <span class="caption text-white">@lang('FDR')</span>
                            </div>
                            <div class="d-widget__icon border-radius--100">
                                <i class="las la-money-bill"></i>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
            @if ($general->modules->dps)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('user.dps.list') }}" class="w-100 h-100">
                        <div class="d-widget section--bg2 d-flex flex-wrap align-items-center rounded-3 bg_img h-100" style="background-image: url('{{ asset($activeTemplateTrue . 'images/elements/card-bg.png') }} ');">
                            <div class="d-widget__content">
                                <h3 class="d-number text-white">{{ @$widget['total_dps'] }}</h3>
                                <span class="caption text-white">@lang('DPS')</span>
                            </div>
                            <div class="d-widget__icon border-radius--100">
                                <i class="las la-box-open"></i>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
            @if ($general->modules->loan)
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('user.loan.list') }}" class="w-100 h-100">
                        <div class="d-widget section--bg2 d-flex flex-wrap align-items-center rounded-3 bg_img h-100" style="background-image: url('{{ asset($activeTemplateTrue . 'images/elements/card-bg.png') }} ');">
                            <div class="d-widget__content">
                                <h3 class="d-number text-white">{{ @$widget['total_loan'] }}</h3>
                                <span class="caption text-white">@lang('Loan')</span>
                            </div>
                            <div class="d-widget__icon border-radius--100">
                                <i class="las la-hand-holding-usd"></i>
                            </div>
                        </div>
                    </a>
                </div>
            @endif
        </div>

        @if ($general->modules->referral_system)
            <div class="row gy-4 mt-3">
                <div class="col-12">
                    <div class="d-widget d-flex flex-wrap align-items-center rounded-3">
                        <label for="lastname" class="col-form-label">@lang('My Referral Link'):</label>
                        <div class="input-group">
                            <input type="url" id="ref" value="{{ route('home') . '?reference=' . auth()->user()->username }}" class="form--control bg-transparent" readonly>
                            <button type="button" class="input-group-text bg--base copybtn border-0 text-white"><i class="fa fa-copy"></i> &nbsp; @lang('Copy')</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row gy-4 mt-3">
            <div class="col-lg-6">
                <h4 class="mb-3">@lang('Latest Credits')</h3>
                    <div class="custom--card">
                        <div class="card-body p-0">
                            <div class="table-responsive--md">
                                <table class="table custom--table mb-0">
                                    <thead>
                                        <tr>
                                            <th>@lang('S.N.')</th>
                                            <th>@lang('Date')</th>
                                            <th>@lang('Trx')</th>
                                            <th>@lang('Amount')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($credits as $credit)
                                            <tr>
                                                <td>{{ __($loop->iteration) }}</td>
                                                <td>
                                                    {{ showDateTime($credit->created_at, 'd M, Y h:i A') }}
                                                </td>
                                                <td>{{ __($credit->trx) }}</td>
                                                <td class="fw-bold">
                                                    {{ showAmount($credit->amount) }} {{ __($general->cur_text) }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="col-lg-6">
                <h4 class="mb-3">@lang('Latest Debits')</h3>
                    <div class="custom--card">
                        <div class="card-body p-0">
                            <div class="table-responsive--md">
                                <table class="table custom--table mb-0">
                                    <thead>
                                        <tr>
                                            <th>@lang('S.N.')</th>
                                            <th>@lang('Date')</th>
                                            <th>@lang('Trx')</th>
                                            <th>@lang('Amount')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($debits as $debit)
                                            <tr>
                                                <td>{{ __($loop->iteration) }}</td>
                                                <td>{{ showDateTime($debit->created_at, 'd M, Y h:i A') }}</td>
                                                <td>{{ __($debit->trx) }}</td>
                                                <td class="fw-bold">
                                                    {{ showAmount($debit->amount) }}{{ __($general->cur_text) }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

    </div>
@endsection

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.copybtn').on('click', function() {
                var copyText = $(this).siblings('#ref')[0];
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand("copy");
                copyText.blur();
                $(this).addClass('copied');
                setTimeout(() => {
                    $(this).removeClass('copied');
                }, 1500);
            });
        })(jQuery);
    </script>
@endpush
