@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="custom--card">
                    <div class="card-body p-0">
                        <div class="table-responsive--md">
                            <table class="custom--table table">
                                <thead>
                                    <tr>
                                        <th>@lang('S.N.')</th>
                                        <th>@lang('DPS No.') | @lang('Plan')</th>
                                        <th>@lang('Amount')</th>
                                        <th>@lang('Installment')</th>
                                        <th>@lang('Next Installment')</th>
                                        <th>@lang('After Matured')</th>
                                        <th>@lang('Status')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($allDps as $dps)
                                        <tr>
                                            <td>{{ $loop->index + $allDps->firstItem() }}</td>

                                            <td>
                                                {{ $dps->dps_number }}
                                                <small class="d-block text--base">{{ __(@$dps->plan->name) }}</small>
                                            </td>

                                            <td>
                                                {{ $general->cur_sym . showAmount($dps->per_installment) }}
                                                <small class="text--base d-block">@lang('Per') {{ __($dps->installment_interval) }} @lang('days')</small>
                                            </td>

                                            <td>
                                                @lang('Total') : {{ $dps->total_installment }}
                                                <small class="text--base d-block">@lang('Given') : {{ $dps->given_installment }}</small>
                                            </td>

                                            <td>{{ showDateTime(@$dps->nextInstallment->installment_date, 'd M, Y') }}</td>

                                            <td>
                                                {{ $general->cur_sym }}{{ showAmount($dps->depositedAmount() + $dps->profitAmount()) }}
                                                <small class="text--base d-block">
                                                    {{ $general->cur_sym }}{{ showAmount($dps->depositedAmount()) }}
                                                    + {{ getAmount($dps->interest_rate) }}%
                                                </small>
                                            </td>

                                            <td>@php echo $dps->statusBadge;@endphp</td>
                                            <td>
                                                <div class="btn--group">
                                                    @if ($dps->status == 2)
                                                        <button class="btn btn-outline--base btn-sm withdrawBtn" data-id="{{ $dps->id }}" data-dps_number="{{ $dps->dps_number }}" data-per_installment="{{ $general->cur_sym . showAmount($dps->per_installment) }}" data-total_installment="{{ $dps->total_installment }}" data-total_deposited="{{ $general->cur_sym . showAmount($dps->depositedAmount()) }}" data-interest_rate="{{ getAmount($dps->interest_rate) }}%" data-profit_amount="{{ $general->cur_sym . showAmount($dps->profitAmount()) }}" data-delay_charge="{{ $general->cur_sym . showAmount($dps->delay_charge) }}" data-withdrawable_amount="{{ $general->cur_sym . showAmount($dps->withdrawableAmount()) }}" type="button">
                                                            <i class="la la-money-check"></i> @lang('Withdraw')
                                                        </button>
                                                    @else
                                                        <button class="btn btn-outline--base btn-sm withdrawBtn" type="button" disabled>
                                                            <i class="la la-money-check"></i> @lang('Withdraw')
                                                        </button>
                                                    @endif

                                                    <a class="btn btn-outline--primary btn-sm" href="{{ route('user.dps.instalment.logs', $dps->dps_number) }}">
                                                        <i class="las la-wallet"></i> @lang('Installments')
                                                    </a>
                                                </div>
                                            </td>

                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($allDps->hasPages())
                        <div class="card-footer py-2">
                            {{ paginateLinks($allDps) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endsection

    @push('script')
        <script>
            (function($) {
                "use strict";

                $('.withdrawBtn').on('click', function() {
                    let modal = $('#wihtdrawModal');
                    let data = $(this).data();
                    $.each(data, function(i, value) {
                        $(`.${i}`).text(value);
                    });
                    let form = modal.find('form')[0];
                    form.action = `{{ route('user.dps.withdraw', '') }}/${$(this).data('id')}`
                    modal.modal('show');
                });
            })(jQuery);
        </script>
    @endpush

    @push('bottom-menu')
        <li><a href="{{ route('user.dps.plans') }}">@lang('DPS Plans')</a></li>
        <li><a class="active" href="{{ route('user.dps.list') }}">@lang('My DPS List')</a></li>
    @endpush

    @push('modal')
        <div class="modal fade" id="wihtdrawModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title">@lang('Withdrawal Preview')</h6>
                        <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close"><i class="las la-times"></i></span>
                    </div>
                    <form action="" method="post">
                        @csrf
                        <div class="modal-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    @lang('DPS Number')
                                    <span class="dps_number"></span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    @lang('Per Installment')
                                    <span class="per_installment">14</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    @lang('Total Installment')
                                    <span class="total_installment">14</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    @lang('Total Deposited')
                                    <span class="total_deposited">2</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    @lang('Interest Rate')
                                    <span class="interest_rate">2</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    @lang('Profit Amount')
                                    <span class="profit_amount">2</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    @lang('Installment Delay Charge')
                                    <span class="delay_charge">2</span>
                                </li>

                                <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                    @lang('Withdrawable Amount')
                                    <span class="withdrawable_amount">1</span>
                                </li>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-sm btn--dark" data-bs-dismiss="modal" type="button">@lang('Cancel')</button>
                            <button class="btn btn-sm btn--base" type="submit">@lang('Withdraw')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endpush
