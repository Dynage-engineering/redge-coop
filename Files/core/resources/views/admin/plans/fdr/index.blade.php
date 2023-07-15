@extends('admin.layouts.app')
@section('panel')
    <div class="card b-radius--10">
        <div class="card-body p-0">
            <div class="table-responsive--md table-responsive">
                <table class="table table--light style--two">
                    <thead>
                        <tr>
                            <th>@lang('S.N.')</th>
                            <th>@lang('Plan')</th>
                            <th>@lang('Users Profit')</th>
                            <th>@lang('Deposit Amount')</th>
                            <th>@lang('Status')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plans as $plan)
                            <tr>
                                <td>{{ $loop->index + $plans->firstItem() }}</td>

                                <td>
                                    <span class="fw-bold text--primary">{{ __($plan->name) }}</span>
                                    <br>
                                    <span class="fw-bold">{{ $plan->locked_days }}</span> @lang('Days Lock-in Period')
                                </td>

                                <td>
                                    <span class="text--primary fw-bold">{{ getAmount($plan->interest_rate) }}%</span>
                                    @lang('of Total Amount')
                                    <br>
                                    @lang('For Every') <span class="text--primary">{{ __($plan->installment_interval) }}</span> @lang('Days')
                                </td>

                                <td>
                                    @lang('Min'): <span class="fw-bold">{{ $general->cur_sym }}{{ showAmount($plan->minimum_amount) }}</span>
                                    <br>
                                    @lang('Max'): <span class="fw-bold">{{ $general->cur_sym }}{{ showAmount($plan->maximum_amount) }}</span>
                                </td>

                                <td> @php echo $plan->statusBadge; @endphp </td>

                                <td>
                                    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-resource="{{ $plan }}" data-modal_title="@lang('Edit Plan')" data-has_status="1"><i class="la la-pencil"></i>@lang('Edit')
                                    </button>

                                    @if ($plan->status)
                                        <button type="button" data-action="{{ route('admin.plans.fdr.status', $plan->id) }}" data-question="@lang('Are you sure to disable this plan?')" class="btn btn-sm confirmationBtn btn-outline--danger">
                                            <i class="la la-la la-eye-slash"></i>@lang('Disable')
                                        </button>
                                    @else
                                        <button type="button" data-action="{{ route('admin.plans.fdr.status', $plan->id) }}" data-question="@lang('Are you sure to enable this plan?')" class="btn btn-sm confirmationBtn btn-outline--success">
                                            <i class="la la-la la-eye"></i>@lang('Enable')
                                        </button>
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
        @if ($plans->hasPages())
            <div class="card-footer py-4">
                {{ paginateLinks($plans) }}
            </div>
        @endif
    </div>

    <x-confirmation-modal />

    @include('admin.plans.fdr.form')
@endsection

@push('breadcrumb-plugins')
    <!-- Modal Trigger Button -->
    <button type="button" class="btn btn-sm btn-outline--primary cuModalBtn" data-modal_title="@lang('Add Plan')">
        <i class="las la-plus"></i>@lang('Add Plan')
    </button>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            let modal = $("#cuModal");

            $('[name=interest_rate], [name=minimum_amount], [name=maximum_amount]').on('input', () => calculateProfit());

            function calculateProfit() {
                let minAmount = Number($('[name=minimum_amount]').val());
                let maxAmount = Number($('[name=maximum_amount]').val());
                let interest = Number($('[name=interest_rate]').val()) / 100;
                let interval = $('[name=installment_interval]').val();
                let totalMinAmount = minAmount * interest;
                let totalMaxAmount = maxAmount * interest;

                if (minAmount && maxAmount && interest) {
                    modal.find('#minAmount').text(`${showAmount(totalMinAmount)} @lang($general->cur_text)`);
                    modal.find('#maxAmount').text(`${showAmount(totalMaxAmount)} @lang($general->cur_text)`);
                    modal.find('#perInterval').text(interval);
                    modal.find('.final-amount').removeClass('d-none');
                }
            }

            $('#cuModal').on('show.bs.modal', function(e) {
                calculateProfit();
            });

            $('#cuModal').on('hidden.bs.modal', function(e) {
                modal.find('.final-amount').addClass('d-none');
            });

        })(jQuery);
    </script>
@endpush
