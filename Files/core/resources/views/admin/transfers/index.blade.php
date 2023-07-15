@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('TRX No.') | @lang('Bank')</th>
                                    <th>@lang('Sender')</th>
                                    <th>@lang('Receiver')</th>
                                    <th>@lang('Amount') | @lang('Charge')</th>
                                    <th>@lang('Final Amount')</th>
                                    <th>@lang('Staus')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($transfers as $transfer)
                                    <tr>
                                        <td>{{ $loop->index + $transfers->firstItem() }}</td>

                                        <td>
                                            <span>{{ $transfer->trx }}</span>
                                            <br>
                                            @if ($transfer->beneficiary)
                                                <span class="text--info">
                                                    {{ $transfer->beneficiary->beneficiaryOf->name ?? $general->site_name }}
                                                </span>
                                            @else
                                                <span class="text--warning fw-bold">@lang('Wire Transfer')</span>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="d-block">{{ __($transfer->user->account_number) }}</span>
                                            <a href="{{ route('admin.users.detail', $transfer->user_id) }}">
                                                <span>@</span>{{ __($transfer->user->username) }}
                                            </a>
                                        </td>

                                        <td>
                                            @if ($transfer->beneficiary)
                                                <span class="d-block">{{ __(@$transfer->beneficiary->account_number) }}</span>
                                                <a href="{{ route('admin.users.detail', $transfer->user_id) }}">
                                                    <span>@</span>{{ __(@$transfer->beneficiary->user->username) }}
                                                </a>
                                            @else
                                                {{ $transfer->wireTransferAccountNumber() }}
                                                <br>
                                                <span class="text--base fw-bold">{{ $transfer->wireTransferAccountName() }}</span>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="fw-bold">{{ __($general->cur_sym . showAmount($transfer->amount)) }}</span>
                                            <span class="small d-block">
                                                <span class="text--danger fw-bold">{{ __($general->cur_sym . showAmount($transfer->charge)) }}</span>
                                            </span>
                                        </td>

                                        <td>
                                            <span class="fw-bold"> {{ __($general->cur_sym . showAmount($transfer->final_amount)) }}</span>
                                        </td>

                                        <td>@php echo $transfer->status_badge @endphp</td>

                                        <td>
                                            <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.transfers.details', $transfer->id) }}">
                                                <i class="las la-desktop"></i> @lang('Details')
                                            </a>
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
                @if ($transfers->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($transfers) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form placeholder="TRX No." />
@endpush
