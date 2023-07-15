{{-- modal-- --}}
<div class="modal fade" id="cronModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('Cron Job Setting Instruction')</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <div class="cron-p-style cron-p-style alert-info text--dark p-3"> @lang('To automate Loan, DPS & FDR installments')
                            <code> @lang('cron job') </code> @lang(' set on your server. ') @lang('Set the cron time as minimum as possible')
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>@lang('Loan Cron Command')</label>
                        <div class="input-group">
                            <input type="text" class="form-control copyText" value="curl -s {{ route('cron.loan') }}" readonly>
                            <button class="input-group-text btn--primary copyBtn border-0"> @lang('COPY')</button>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>@lang('DPS Cron Command')</label>
                        <div class="input-group">
                            <input type="text" class="form-control copyText" value="curl -s {{ route('cron.dps') }}" readonly>
                            <button class="input-group-text btn--primary copyBtn border-0"> @lang('COPY')</button>
                        </div>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>@lang('FDR Cron Command')</label>
                        <div class="input-group">
                            <input type="text" class="form-control copyText" value="curl -s {{ route('cron.fdr') }}" readonly>
                            <button class="input-group-text btn--primary copyBtn border-0"> @lang('COPY')</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@push('script')
    @if (Carbon\Carbon::parse($general->last_loan_cron)->diffInSeconds() >= 5400 || Carbon\Carbon::parse($general->last_dps_cron)->diffInSeconds() >= 5400 || Carbon\Carbon::parse($general->last_fdr_cron)->diffInSeconds() >= 5400 || !$general->last_loan_cron || !$general->last_dps_cron || !$general->last_fdr_cron)
        <script>
            'use strict';
            $(document).ready(function(e) {
                $("#cronModal").modal('show');
                $('.copyBtn').on('click', function() {
                    var copyText = $(this).siblings('.copyText')[0];
                    copyText.select();
                    copyText.setSelectionRange(0, 99999);
                    document.execCommand("copy");
                    copyText.blur();
                    $(this).addClass('copied');
                    setTimeout(() => {
                        $(this).removeClass('copied');
                    }, 1500);
                });
            });
        </script>
    @endif
@endpush
