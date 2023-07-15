@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('DPS No.') | @lang('Plan')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Installment')</th>
                                    <th>@lang('Next Installment')</th>
                                    <th>@lang('After Matured')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $dps)
                                    <tr>
                                        <td>{{ __($loop->index + $data->firstItem()) }}</td>

                                        <td>
                                            <span class="fw-bold">{{ __($dps->dps_number) }}</span>
                                            <span class="d-block text--info">{{ __(@$dps->plan->name) }}</span>
                                        </td>

                                        <td>
                                            <span class="fw-bold d-block">{{ __(@$dps->user->fullname) }}</span>
                                            @if ($dps->user)
                                                <span class="small">
                                                    <a href="{{ route('admin.users.detail', $dps->user_id) }}"><span>@</span>{{ @$dps->user->username }}</a>
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <span>{{ $general->cur_sym . showAmount($dps->per_installment) }}</span>
                                            <span class="text--info d-block">@lang('Per')
                                                {{ __($dps->installment_interval) }}
                                                @lang('days')
                                            </span>
                                        </td>

                                        <td>
                                            <span>@lang('Total') : {{ __($dps->total_installment) }}</span>
                                            <span class="text--info d-block">@lang('Given') : {{ __($dps->given_installment) }}</span>
                                        </td>

                                        <td>
                                            @if(@$dps->nextInstallment->installment_date)
                                            {{ showDateTime($dps->nextInstallment->installment_date, 'd M, Y') }}
                                            @endif
                                        </td>

                                        <td>
                                            {{ $general->cur_sym }}{{ showAmount($dps->depositedAmount() + $dps->profitAmount()) }}

                                            <span class="text--info d-block">
                                                {{ $general->cur_sym }} {{ showAmount($dps->depositedAmount()) }}
                                                + {{ getAmount($dps->interest_rate) }}%
                                            </span>
                                        </td>

                                        <td>@php echo $dps->statusBadge;@endphp</td>

                                        <td>
                                            <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.dps.installments', $dps->id) }}">
                                                <i class="las la-history"></i> @lang('Installments')
                                            </a>
                                        </td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($data->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($data) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="DPS No." />
@endpush
