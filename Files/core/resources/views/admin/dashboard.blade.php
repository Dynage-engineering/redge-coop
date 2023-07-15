@extends('admin.layouts.app')
@section('panel')
    @if (@json_decode($general->system_info)->version > systemDetails()['version'])
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card bg-warning mb-3 text-white">
                    <div class="card-header">
                        <h3 class="card-title"> @lang('New Version Available') <button class="btn btn--dark float-end">@lang('Version') {{ json_decode($general->system_info)->version }}</button> </h3>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title text-dark">@lang('What is the Update ?')</h5>
                        <p>
                            <pre class="f-size--24">{{ json_decode($general->system_info)->details }}</pre>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if (@json_decode($general->system_info)->message)
        <div class="row mb-3">
            @foreach (json_decode($general->system_info)->message as $msg)
                <div class="col-md-12">
                    <div class="alert border--primary border" role="alert">
                        <div class="alert__icon bg--primary"><i class="far fa-bell"></i></div>
                        <p class="alert__message">@php echo $msg; @endphp</p>
                        <button class="close" data-bs-dismiss="alert" type="button" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="row gy-4">
        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_users'] }}" title="Total Users" style="2" bg="white" color="primary" icon="la la-users" link="{{ route('admin.users.all') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['verified_users'] }}" title="Active Users" style=2 bg="white" color="success" icon="la la-user-check" link="{{ route('admin.users.all') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['email_unverified_users'] }}" title="Email Unverified Users" style="2" bg="white" color="danger" icon="la la-envelope" link="{{ route('admin.users.email.unverified') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['mobile_unverified_users'] }}" title="Mobile Unverified Users" style="2" bg="white" color="danger" icon="la la-comment-slash" link="{{ route('admin.users.mobile.unverified') }}" icon_style="solid" overlay_icon=0 />
        </div>

        {{-- Deposit Widgets --}}

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_deposit_pending'] }}" title="Pending Deposits" style=2 bg="white" color="warning" icon="fas fa-spinner" link="{{ route('admin.deposit.pending') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_deposit_rejected'] }}" title="Rejected Deposits" style=2 bg="white" color="danger" icon="fas fa-ban" link="{{ route('admin.deposit.rejected') }}" icon_style="solid" overlay_icon=0 />
        </div>

        {{-- Withdraw Widgets --}}

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_withdraw_pending'] }}" title="Pending Withdrawals" style=2 bg="white" color="6" icon="la la-sync" link="{{ route('admin.withdraw.pending') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_withdraw_rejected'] }}" title="Rejected Withdrawals" style=2 bg="white" color="danger" icon="las la-times-circle" link="{{ route('admin.withdraw.rejected') }}" icon_style="solid" overlay_icon=0 />
        </div>

        {{-- Loan Widgets --}}

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_running_loan'] }}" title="Running Loan" style=2 bg="white" color="indigo" icon="las la-hand-holding-usd" link="{{ route('admin.loan.running') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_pending_loan'] }}" title="Pending Loan" style=2 bg="white" color="2" icon="las la-hand-holding-usd" link="{{ route('admin.loan.pending') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_due_loan'] }}" title="Due Loan" style=2 bg="white" color="5" icon="las la-hand-holding-usd" link="{{ route('admin.loan.due') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_paid_loan'] }}" title="Paid Loan" style=2 bg="white" color="success" icon="las la-hand-holding-usd" link="{{ route('admin.loan.paid') }}" icon_style="solid" overlay_icon=0 />
        </div>

        {{-- DPS Widgets --}}
        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_dps'] }}" title="Total DPS" style=2 bg="white" color="info" icon="las la-coins" link="{{ route('admin.dps.index') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_matured_dps'] }}" title="Matured DPS" style=2 bg="white" color="warning" icon="las la-coins" link="{{ route('admin.dps.matured') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_due_dps'] }}" title="Due DPS" style=2 bg="white" color="danger" icon="las la-coins" link="{{ route('admin.dps.due') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_running_dps'] }}" title="Running DPS" style=2 bg="white" color="7" icon="las la-coins" link="{{ route('admin.dps.running') }}" icon_style="solid" overlay_icon=0 />
        </div>

        {{-- FDR Widgets --}}
        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_fdr'] }}" title="Total FDR" style=2 bg="white" color="18" icon="las la-store" link="{{ route('admin.fdr.index') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_running_fdr'] }}" title="Running FDR" style=2 bg="white" color="amber" icon="las la-store" link="{{ route('admin.fdr.running') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_due_fdr'] }}" title="Due FDR" style=2 bg="white" color="5" icon="las la-store" link="{{ route('admin.fdr.due') }}" icon_style="solid" overlay_icon=0 />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget value="{{ $widget['total_closed_fdr'] }}" title="Closed FDR" style=2 bg="white" color="green" icon="las la-store" link="{{ route('admin.fdr.closed') }}" icon_style="solid" overlay_icon=0 />
        </div>
    </div>

    <div class="row gy-4 mt-2">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Monthly Deposit & Withdraw Report') (@lang('Last 12 Month'))</h5>
                    <div id="monthly-dw-report"> </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Transactions Report') (@lang('Last 30 Days'))</h5>
                    <div id="transaction-report"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4 mt-3">
        <div class="col-xl-4 col-lg-6">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Browser') (@lang('Last 30 days'))</h5>
                    <canvas id="userBrowserChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By OS') (@lang('Last 30 days'))</h5>
                    <canvas id="userOsChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">@lang('Login By Country') (@lang('Last 30 days'))</h5>
                    <canvas id="userCountryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.cron_instruction')

@endsection

@push('script-lib')
    <script src="{{ asset('assets/admin/js/vendor/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/vendor/chart.js.2.8.0.js') }}"></script>
    <script src="{{ asset('assets/admin/js/charts.js') }}"></script>
@endpush

@push('script')
    <script>
        "use strict";
        barChart(
            document.querySelector("#monthly-dw-report"),
            `{{ __($general->cur_text) }}`,
            [{
                    name: 'Deposited',
                    data: @json(@$chartData['deposits'])
                },
                {
                    name: 'Withdraw',
                    data: @json(@$chartData['withdrawals'])
                }
            ],
            @json($months)
        );

        lineChart(
            document.querySelector("#transaction-report"),
            [{
                    name: "Plus Transactions",
                    data: @json(@$chartData['plus_trx'])
                },
                {
                    name: "Minus Transactions",
                    data: @json(@$chartData['minus_trx'])
                }
            ],
            @json(@$chartData['trx_dates'])
        );

        piChart(
            document.getElementById('userBrowserChart'),
            @json(@$chartData['user_browser_counter']->keys()),
            @json(@$chartData['user_browser_counter']->flatten())
        );

        piChart(
            document.getElementById('userOsChart'),
            @json(@$chartData['user_os_counter']->keys()),
            @json(@$chartData['user_os_counter']->flatten())
        );

        piChart(
            document.getElementById('userCountryChart'),
            @json(@$chartData['user_country_counter']->keys()),
            @json(@$chartData['user_country_counter']->flatten())
        );
    </script>
@endpush
