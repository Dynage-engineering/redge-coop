@extends('admin.layouts.app')

@section('panel')
    <div class="row justify-content-center">
        @if (request()->routeIs('admin.withdraw.log') || request()->routeIs('admin.withdraw.method') || request()->routeIs('admin.users.withdrawals') || request()->routeIs('admin.users.withdrawals.method'))
            <div class="col-xl-4 col-sm-6 mb-30">
                <x-widget style="4" bg="success" title="Approved Withdrawals" value="{{ __($general->cur_sym) }}{{ showAmount($successful) }}" link="{{ route('admin.withdraw.approved') }}" />
            </div>

            <div class="col-xl-4 col-sm-6 mb-30">
                <x-widget style="4" bg="6" title="Pending Withdrawals" value="{{ __($general->cur_sym) }}{{ showAmount($pending) }}" link="{{ route('admin.withdraw.pending') }}" />
            </div>
            <div class="col-xl-4 col-sm-6 mb-30">
                <x-widget style="4" bg="5" title="Rejected Withdrawals" value="{{ __($general->cur_sym) }}{{ showAmount($rejected) }}" link="{{ route('admin.withdraw.rejected') }}" />
            </div>
        @endif
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('Method | Transaction')</th>
                                    <th>@lang('Branch')</th>
                                    <th>@lang('User')</th>
                                    <th>@lang('Initiated')</th>
                                    <th>@lang('Amount')</th>
                                    <th>@lang('Conversion')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>

                                </tr>
                            </thead>
                            <tbody>
                                @forelse($withdrawals as $withdraw)
                                    @php
                                        $details = $withdraw->withdraw_information != null ? json_encode($withdraw->withdraw_information) : null;
                                    @endphp
                                    <tr>
                                        <td>
                                            @if ($withdraw->branch)
                                                <span class="fw-bold">@lang('From Branch')</span>
                                            @else
                                                <span class="fw-bold" title="@lang('Gateway Name')">
                                                    <a href="{{ appendQuery('method', @$withdraw->method->id) }}">{{ __(@$withdraw->method->name) }}</a>
                                                </span>
                                            @endif

                                            <br>
                                            <small>{{ $withdraw->trx }}</small>
                                        </td>

                                        <td>
                                            @if ($withdraw->branch)
                                                <a href="{{ route('admin.branch.details', $withdraw->branch_id) }}" class="fw-bold text--primary" title="@lang('Branch Name')"> {{ __(@$withdraw->branch->name) }}</a>
                                                <br>

                                                <a href="{{ route('admin.branch.staff.details', $withdraw->branch_staff_id) }}" class="fw-bold text--info" title="@lang('Staff Name')"> {{ __(@$withdraw->branchStaff->name) }}</a>
                                                <br>
                                            @else
                                                <span class="fw-bold">@lang('Online')</span>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="fw-bold">{{ $withdraw->user->fullname }}</span>
                                            <br>
                                            <span class="small"> <a href="{{ appendQuery('search', @$withdraw->user->username) }}"><span>@</span>{{ $withdraw->user->username }}</a> </span>
                                        </td>

                                        <td>
                                            {{ showDateTime($withdraw->created_at) }} <br> {{ diffForHumans($withdraw->created_at) }}
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
                                            <a class="btn btn-sm btn-outline--primary ms-1" href="{{ route('admin.withdraw.details', $withdraw->id) }}">
                                                <i class="la la-desktop"></i> @lang('Details')
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                @if ($withdrawals->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($withdrawals) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    @if (request()->routeIs('admin.withdraw.log'))
        <div class="btn-group">
            <button class="btn btn-outline--primary dropdown-toggle" data-bs-toggle="dropdown" type="button">
                @if (request()->branch === 0)
                    @lang('Online')
                @elseif(request()->branch)
                    @php $branch = $branches->where('id', request()->branch)->first(); @endphp
                    {{ @$branch->name }}
                @else
                    @lang('All Branch')
                @endif
            </button>

            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['branch' => null]) }}">@lang('All Branch')</a>
                </li>

                <li>
                    <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['branch' => 0]) }}">@lang('Online')</a>
                </li>

                @foreach ($branches as $branch)
                    <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['branch' => $branch->id]) }}">{{ __($branch->name) }}</a></li>
                @endforeach
            </ul>
        </div>
    @endif
    <x-search-form dateSearch='yes' />
@endpush
