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
                                    <th>@lang('TRX')</th>
                                    <th>@lang('Account Name')</th>
                                    <th>@lang('Account Number')</th>
                                    <th>@lang('Bank')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Status')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($transfers as $transfer)
                                    <tr>
                                        <td>{{ $loop->index + $transfers->firstItem() }}</td>
                                        <td>{{ $transfer->trx }}</td>
                                        <td>{{ @$transfer->benificiary->account_name }}</td>
                                        <td>{{ @$transfer->benificiary->account_number }}</td>
                                        <td>{{ __(@$transfer->bank->name ?? $general->site_name) }}</td>
                                        <td>{{ $general->cur_sym . showAmount($transfer->amount) }}</td>
                                        <td>
                                            @if ($transfer->status == 1)
                                                <span class="badge badge--success">
                                                    @lang('Completed')
                                                </span>
                                            @elseif($transfer->status == 0)
                                                <span class="badge badge--warning">
                                                    @lang('Pending')
                                                </span>
                                            @elseif($transfer->status == 2)
                                                <span class="badge badge--danger">
                                                    @lang('Rejected')
                                                </span>
                                            @endif
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
