@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Plan')</th>
                                    <th>@lang('Installment')</th>
                                    <th>@lang('After Mature')</th>
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
                                            <span class="fw-bold">{{ getAmount($plan->interest_rate) }}%</span> <small>@lang('Interest rate')</small>
                                        </td>

                                        <td>
                                            <span class="fw-bold">
                                                {{ $general->cur_sym . showAmount($plan->per_installment) }}
                                            </span>
                                            <br>
                                            @lang('Per') <span class="fw-bold">{{ $plan->installment_interval }}</span> @lang('days')
                                            @lang('for') <span class="fw-bold">{{ $plan->total_installment }}</span> @lang('times')
                                        </td>

                                        <td>
                                            @php $profit = $plan->total_installment * $plan->per_installment - 100; @endphp

                                            <span class="fw-bold text--info">{{ $general->cur_sym . showAmount($plan->final_amount) }}</span>
                                            <br>
                                            @lang('After')
                                            <span class="text--primary">
                                                {{ $plan->total_installment * $plan->installment_interval }}
                                            </span>
                                            @lang('days')
                                        </td>

                                        <td> @php echo $plan->statusBadge; @endphp </td>

                                        <td>
                                            <a href="{{ route('admin.plans.dps.edit', $plan->id) }}" class="btn btn-sm btn-outline--primary">
                                                <i class="la la-pencil"></i>@lang('Edit')
                                            </a>

                                            @if ($plan->status)
                                                <button type="button" data-action="{{ route('admin.plans.dps.status', $plan->id) }}" data-question="@lang('Are you sure to disable this plan?')" class="btn btn-sm confirmationBtn btn-outline--danger">
                                                    <i class="la la-la la-eye-slash"></i>@lang('Disable')
                                                </button>
                                            @else
                                                <button type="button" data-action="{{ route('admin.plans.dps.status', $plan->id) }}" data-question="@lang('Are you sure to enable this plan?')" class="btn btn-sm confirmationBtn btn-outline--success">
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
            </div><!-- card end -->
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.plans.dps.add') }}" class="btn btn-sm btn-outline--primary">
        <i class="las la-plus"></i>@lang('Add Plan')
    </a>
@endpush
