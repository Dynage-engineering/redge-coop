@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="py-5">
        <div class="container">
            <div class="d-flex justify-content-end mb-4 gap-2">
                <a class="btn h-45 btn--base" href="{{ route('user.withdraw') }}">
                    <i class="las la-wallet"></i> @lang('Withdraw Money')
                </a>
                <x-search-form placeholder="TRX No." btn="btn--base" />
            </div>

            <div class="card custom--card">
                <div class="card-body p-0">
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
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($withdraws as $withdraw)
                                    <tr>
                                        <td>{{ __($loop->index + $withdraws->firstItem()) }}</td>

                                        <td>
                                            @if ($withdraw->branch)
                                                <span class="fw-bold">
                                                    <span class="text-primary" title="@lang('Branch Name')">{{ __(@$withdraw->branch->name) }}</span>
                                                </span>
                                            @else
                                                <span class="fw-bold"><span class="text-primary" title="@lang('Method Name')"> {{ __(@$withdraw->method->name) }}</span></span>
                                            @endif
                                            <br>
                                            <small>{{ $withdraw->trx }}</small>
                                        </td>

                                        <td>
                                            <em>{{ showDateTime($withdraw->created_at) }} </em>
                                            <br> {{ diffForHumans($withdraw->created_at) }}
                                        </td>

                                        <td>
                                            {{ __($general->cur_sym) }}{{ showAmount($withdraw->amount) }} - <span class="text-danger" title="@lang('charge')">{{ showAmount($withdraw->charge) }} </span>
                                            <br>
                                            <strong title="@lang('Amount after charge')">
                                                {{ showAmount($withdraw->amount - $withdraw->charge) }} {{ __($general->cur_text) }}
                                            </strong>

                                        </td>

                                        <td>
                                            1 {{ __($general->cur_text) }} = {{ showAmount($withdraw->rate) }} {{ __($withdraw->currency) }}
                                            <br>
                                            <strong>{{ showAmount($withdraw->final_amount) }} {{ __($withdraw->currency) }}</strong>
                                        </td>

                                        <td>
                                            @php echo $withdraw->statusBadge @endphp
                                        </td>

                                        <td>
                                            <button class="btn btn-sm btn-outline--base detailBtn" data-user_data="{{ json_encode($withdraw->withdraw_information) }}" @if ($withdraw->status == Status::PAYMENT_REJECT) data-admin_feedback="{{ $withdraw->admin_feedback }}" @endif>
                                                <i class="la la-desktop"></i> @lang('Details')
                                            </button>
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
                @if ($withdraws->hasPages())
                    <div class="card-footer">
                        {{ $withdraws->links() }}
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
            $('.detailBtn').on('click', function() {
                var modal = $('#detailModal');
                var userData = $(this).data('user_data');
                var html = ``;

                userData.forEach(element => {
                    if (element.type != 'file') {
                        html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>${element.name}</span>
                            <span">${element.value}</span>
                        </li>`;
                    }
                });

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
                <div class="modal-body">
                    <ul class="list-group list-group-flush userData">

                    </ul>
                    <div class="feedback"></div>
                </div>

            </div>
        </div>
    </div>
@endpush
