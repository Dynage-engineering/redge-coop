@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="custom--card">
                    <div class="card-body p-0">
                        <div class="table-responsive--md">
                            <table class="table custom--table">
                                <thead>
                                    <tr>
                                        <th>@lang('S.N.')</th>
                                        <th>@lang('FDR No.') | @lang('Plan')</th>
                                        <th>@lang('Amount')</th>
                                        <th>@lang('Profit')</th>
                                        <th>@lang('Next Installment')</th>
                                        <th>@lang('Lock In Period')</th>
                                        <th>@lang('Status')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($allFdr as $fdr)
                                        <tr>
                                            <td>{{ $loop->index + $allFdr->firstItem() }}</td>

                                            <td>
                                                <strong>{{ $fdr->fdr_number }}</strong>
                                                <small class="d-block text--base">{{ __($fdr->plan->name) }}</small>
                                            </td>

                                            <td>
                                                <strong>{{ $general->cur_sym . showAmount($fdr->amount) }}</strong>
                                                <small class="d-block text--base">
                                                    @lang('With') {{ getAmount($fdr->interest_rate) }}% @lang('Profit Rate')
                                                </small>
                                            </td>

                                            <td>
                                                {{ $general->cur_sym . showAmount($fdr->per_installment) }}
                                                <small class="text--base d-block">@lang('Per') {{ $fdr->installment_interval }} @lang('Days')</small>
                                            </td>

                                            <td>
                                                @if ($fdr->status != 2)
                                                    {{ showDateTime($fdr->next_installment_date, 'd M, Y') }}
                                                @else
                                                    @lang('N/A')
                                                @endif
                                            </td>

                                            <td>
                                                {{ showDateTime($fdr->locked_date->endOfDay(), 'd M, Y h:i A') }}
                                                <small class="d-block text--base">{{ diffForHumans($fdr->locked_date, 'd M, Y') }}</small>
                                            </td>

                                            <td>@php echo $fdr->statusBadge; @endphp</td>

                                            <td>
                                                <div class="btn--group">
                                                    <button type="button" data-id="{{ $fdr->id }}" class="btn btn-outline--base btn-sm closeBtn" @disabled(($fdr->locked_date->endOfDay() >= now() && $fdr->status == 1) || $fdr->status == 2)>
                                                        <i class="fa fa-stop-circle"></i> @lang('Close')
                                                    </button>

                                                    <a href="{{ route('user.fdr.instalment.logs', $fdr->fdr_number) }}" class="btn btn-outline--primary btn-sm">
                                                        <i class="las la-wallet"></i> @lang('Installments')
                                                    </a>
                                                </div>
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
                    @if ($allFdr->hasPages())
                        <div class="card-footer py-2">
                            {{ paginateLinks($allFdr) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.closeBtn').on('click', function() {
                let modal = $('#closeFdr');
                let form = modal.find('form')[0];
                form.action = `{{ route('user.fdr.close', '') }}/${$(this).data('id')}`
                modal.modal('show');
            });
        })(jQuery);
    </script>
@endpush

@push('bottom-menu')
    <li><a href="{{ route('user.fdr.plans') }}">@lang('FDR Plans')</a></li>
    <li><a href="{{ route('user.fdr.list') }}" class="active">@lang('My FDR List')</a></li>
@endpush

@push('modal')
    <div class="modal fade" id="closeFdr" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Close FDR')</h5>
                    <button type="button" class="bg-transparent" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>

                <form action="" method="post">
                    @csrf
                    <input type="hidden" name="user_token" required>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="id" class="transferId" required>
                        </div>
                        <div class="content">
                            <p>@lang('Are you sure to close this FDR?')</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-md btn-danger text-white" data-bs-dismiss="modal">@lang('No')</button>
                        <button type="submit" class="btn btn-md custom--bg text-white">@lang('Yes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush
