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
                                    <th>@lang('FDR No.') | @lang('Plan')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Profit')</th>
                                    <th>@lang('Next Installment')</th>
                                    <th>@lang('Lock-In Period')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $fdr)
                                    <tr>
                                        <td>{{ $loop->index + $data->firstItem() }}</td>

                                        <td>
                                            <span class="fw-bold">{{ __($fdr->fdr_number) }}</span>
                                            <span class="d-block text-muted">{{ __(@$fdr->plan->name) }}</span>
                                        </td>

                                        <td>
                                            <span class="fw-bold d-block">{{ __(@$fdr->user->fullname) }}</span>
                                            @if ($fdr->user)
                                                <span class="small">
                                                    <a href="{{ route('admin.users.detail', $fdr->user_id) }}"><span>@</span>{{ $fdr->user->username }}</a>
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <span>{{ $general->cur_sym . showAmount($fdr->amount) }}</span>
                                            <span class="d-block text-muted">@lang('Profit') {{ getAmount($fdr->interest_rate) }}% </span>
                                        </td>

                                        <td>
                                            <span>{{ $general->cur_sym . showAmount($fdr->per_installment) }}</span>
                                            <span class="text-muted d-block">@lang('Per') {{ $fdr->installment_interval }}@lang('Days')</span>
                                        </td>

                                        <td>
                                            @if ($fdr->status != 2)
                                                <span>{{ showDateTime($fdr->next_installment_date, 'd M, Y') }}</span>
                                            @else
                                                @lang('N/A')
                                            @endif
                                        </td>

                                        <td>
                                            <span> {{ showDateTime($fdr->locked_date, 'd M, Y') }} </span>
                                            <span class="d-block text-muted">{{ diffForHumans($fdr->locked_date, 'd M, Y') }}</span>
                                        </td>

                                        <td>@php echo $fdr->statusBadge; @endphp</td>

                                        <td>
                                            <div class="button--group">
                                                @if ($fdr->next_installment_date < today())
                                                    <button class="btn btn-sm btn-outline--warning paymentBtn" data-per_installment="{{ $general->cur_sym . $fdr->per_installment }}" data-installments="{{ $fdr->dueInstallment() }}" data-amount="{{ $general->cur_sym . showAmount($fdr->dueAmount()) }}" data-action="{{ route('admin.fdr.due.pay', $fdr->id) }}">@lang('Pay Due')</button>
                                                @endif

                                                <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.fdr.installments', $fdr->id) }}">
                                                    <i class="las la-history"></i>
                                                    @lang('Installments')
                                                </a>
                                            </div>
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
            </div><!-- card end -->
        </div>
    </div>

    <div class="modal fade" id="paymentModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">@lang('Pay Due Installments')</h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="" method="post">
                    @csrf
                    <div class="modal-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between flex-wrap">
                                <span>@lang('Delayed Installments')</span>
                                <span class="delayed-installments"></span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between flex-wrap">
                                <span>@lang('Per Installment')</span>
                                <span class="per-installment"></span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between flex-wrap">
                                <span>@lang('Total Amount')</span>
                                <span class="installment-amount"></span>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--dark btn-sm" data-bs-dismiss="modal" type="button">@lang('Cancel')</button>
                        <button class="btn btn--primary btn-sm" type="submit">@lang('Pay All')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-search-form />
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.paymentBtn').on('click', function() {
                let modal = $('#paymentModal');
                let data = $(this).data();
                let form = modal.find('form')[0];
                form.action = data.action;
                modal.find('.delayed-installments').text(data.installments);
                modal.find('.per-installment').text(data.per_installment);
                modal.find('.installment-amount').text(data.amount);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush
