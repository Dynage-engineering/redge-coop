@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">

        <div class="d-flex justify-content-end align-content-center mb-4 gap-2">
            <a class="btn h-45 btn--base" href="{{ route('user.deposit.index') }}">
                <i class="las la-plus"></i>
                @lang('Deposit Now')
            </a>
            <x-search-form placeholder="TRX No." btn="btn--base" />
        </div>

        <div class="table-responsive--md">
            <table class="custom--table table">
                <thead>
                    <tr>
                        <th>@lang('S.N.')</th>
                        <th>@lang('Gateway') | @lang('TRX No.')</th>
                        <th>@lang('Initiated')</th>
                        <th>@lang('Amount')</th>
                        <th>@lang('Conversion')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Details')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deposits as $deposit)
                        <tr>
                            <td>{{ $loop->index + $deposits->firstItem() }}</td>

                            <td>
                                @if ($deposit->branch)
                                    <span class="fw-bold"><span class="text-primary" title="@lang('Branch Name')"> {{ __(@$deposit->branch->name) }}</span>
                                    @else
                                        <span class="fw-bold"><span class="text-primary" title="@lang('Gateway Name')"> {{ __(@$deposit->gateway->name) }}</span>
                                @endif
                                <br>
                                <small> {{ $deposit->trx }} </small>
                            </td>

                            <td>
                                <em>
                                    {{ showDateTime($deposit->created_at) }}
                                    <br>
                                    {{ diffForHumans($deposit->created_at) }}
                                </em>
                            </td>

                            <td>
                                {{ __($general->cur_sym) }}{{ showAmount($deposit->amount) }} + <span class="text-danger" title="@lang('charge')">{{ showAmount($deposit->charge) }} </span>
                                <br>
                                <strong title="@lang('Amount with charge')">
                                    {{ showAmount($deposit->amount + $deposit->charge) }} {{ __($general->cur_text) }}
                                </strong>
                            </td>

                            <td>
                                1 {{ __($general->cur_text) }} = {{ showAmount($deposit->rate) }}
                                {{ __($deposit->method_currency) }}
                                <br>
                                <strong>{{ showAmount($deposit->final_amo) }}
                                    {{ __($deposit->method_currency) }}</strong>
                            </td>

                            <td> @php echo $deposit->statusBadge @endphp</td>

                            @php
                                $details = $deposit->detail != null ? json_encode($deposit->detail) : null;
                            @endphp

                            <td>
                                <button class="btn btn-outline--base btn-sm @if ($deposit->method_code >= 1000) detailBtn @else disabled @endif" type="button" @if ($deposit->method_code >= 1000) data-info="{{ $details }}" @endif @if ($deposit->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $deposit->admin_feedback }}" @endif>
                                    <i class="la la-desktop"></i> @lang('Details')
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="100%">{{ __($emptyMessage) }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($deposits->hasPages())
            <div class="mt-3">
                {{ $deposits->links() }}
            </div>
        @endif
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var userData = $(this).data('info');
                var html = '';

                if (userData) {
                    userData.forEach(element => {
                        if (element.type != 'file') {
                            html += `
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>${element.name}</span>
                                <span">${element.value}</span>
                            </li>`;
                        }
                    });
                }
                modal.find('.userData').html(html);
                if ($(this).data('admin_feedback') != undefined) {
                    var adminFeedback = `
                        <div class="my-3">
                            <strong>@lang('Admin Feedback')</strong>
                            <p>${$(this).data('admin_feedback')}</p>
                        </div>
                    `;
                } else {
                    var adminFeedback = '';
                }
                modal.find('.feedback').html(adminFeedback);
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush

@push('style')
    <style>
        .c-p {
            padding: 12px !important;
        }
    </style>
@endpush

@push('modal')
    <div class="modal fade" id="detailModal" role="dialog" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Details')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body p-0">
                    <ul class="list-group list-group-flush userData mb-2">
                    </ul>
                    <div class="feedback"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark btn-sm" data-bs-dismiss="modal" type="button">@lang('Close')</button>
                </div>
            </div>
        </div>
    </div>
@endpush
