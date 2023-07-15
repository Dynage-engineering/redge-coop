@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--lg table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Loan No.') | @lang('Plan')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Installment Amount')</th>
                                    <th>@lang('Installment')</th>
                                    <th>@lang('Next Installment')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($loans as $loan)
                                    <tr>
                                        <td>{{ __($loop->index + $loans->firstItem()) }}</td>
                                        <td>
                                            <span class="fw-bold">{{ __($loan->loan_number) }}</span>
                                            <span class="d-block text--info">{{ __($loan->plan->name) }}</span>
                                        </td>
                                        <td>
                                            <span class="fw-bold d-block">{{ $loan->user->account_number }}</span>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', $loan->user_id) }}"><span>@</span>{{ $loan->user->username }}</a>
                                            </span>
                                        </td>
                                        <td>
                                            <span>{{ $general->cur_sym . showAmount($loan->amount) }}</span>
                                            <span class="d-block text--info">
                                                {{ $general->cur_sym . showAmount($loan->payable_amount) }} @lang('Receivable')
                                            </span>
                                        </td>

                                        <td>
                                            <span>{{ $general->cur_sym . showAmount($loan->per_installment) }}</span>
                                            <span class="d-block text--info">
                                                @lang('Per') {{ $loan->installment_interval }} @lang('days')
                                            </span>
                                        </td>

                                        <td>
                                            <span>@lang('Total') : {{ $loan->total_installment }}</span>
                                            <span class="d-block text--info">@lang('Given') : {{ $loan->given_installment }}</span>
                                        </td>

                                        <td>
                                            @if ($loan->nextInstallment)
                                                {{ showDateTime($loan->nextInstallment->installment_date, 'd M, Y') }}
                                            @else
                                                @lang('N\A')
                                            @endif
                                        </td>

                                        <td>
                                            @php echo $loan->status_badge; @endphp
                                        </td>

                                        <td>
                                            <div class="button--group">
                                                <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.loan.details', $loan->id) }}">
                                                    <i class="las la-desktop"></i> @lang('Details')
                                                </a>

                                                <a class="btn btn-sm btn-outline--success" href="{{ route('admin.loan.installments', $loan->id) }}">
                                                    <i class="las la-history"></i> @lang('Installments')
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
                @if ($loans->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($loans) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="Loan No." />
@endpush
