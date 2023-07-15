@extends('admin.layouts.app')

@section('panel')
    <div class="row justify-content-center">
        @if (request()->routeIs('admin.deposit.list') || request()->routeIs('admin.deposit.method') || request()->routeIs('admin.users.deposits') || request()->routeIs('admin.users.deposits.method') || request()->routeIs('admin.branch.deposit.logs') || request()->routeIs('admin.branch.staff.deposit.logs'))
            <div class="col-xxl-3 col-sm-6 mb-30">
                <x-widget style="4" bg="success" title="Successful Deposit" value="{{ __($general->cur_sym) }}{{ showAmount($successful) }}" link="{{ route('admin.deposit.successful') }}" />
            </div>

            <div class="col-xxl-3 col-sm-6 mb-30">
                <x-widget style="4" bg="warning" title="Pending Deposit" value="{{ __($general->cur_sym) }}{{ showAmount($pending) }}" link="{{ route('admin.deposit.pending') }}" />
            </div>

            <div class="col-xxl-3 col-sm-6 mb-30">
                <x-widget style="4" bg="danger" title="Rejected Deposit" value="{{ __($general->cur_sym) }}{{ showAmount($rejected) }}" link="{{ route('admin.deposit.rejected') }}" />
            </div>

            <div class="col-xxl-3 col-sm-6 mb-30">
                <x-widget style="4" bg="dark" title="Initiated Deposit" value="{{ __($general->cur_sym) }}{{ showAmount($rejected) }}" link="{{ route('admin.deposit.initiated') }}" />
            </div>
        @endif

        <div class="col-md-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('Gateway | Transaction')</th>
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
                                @forelse($deposits as $deposit)
                                    @php
                                        $details = $deposit->detail ? json_encode($deposit->detail) : null;
                                    @endphp
                                    <tr>
                                        <td>
                                            @if ($deposit->branch)
                                                <span class="text--primary fw-bold">@lang('From Branch')</span>
                                            @else
                                                <span class="fw-bold">
                                                    <a href="{{ appendQuery('method', @$deposit->gateway->alias) }}">{{ __(@$deposit->gateway->name) }}</a>
                                                </span>
                                            @endif
                                            <br>
                                            <small> {{ $deposit->trx }} </small>
                                        </td>

                                        <td>
                                            @if ($deposit->branch)
                                                <a href="{{ route('admin.branch.details', $deposit->branch_id) }}" class="fw-bold text--primary"> {{ __(@$deposit->branch->name) }}</a>
                                                <br>
                                                <a href="{{ route('admin.branch.staff.details', $deposit->branch_staff_id) }}"> {{ __(@$deposit->branchStaff->name) }}</a>
                                            @else
                                                <span class="fw-bold">@lang('Online')</span>
                                            @endif
                                        </td>

                                        <td>
                                            <span class="fw-bold">{{ $deposit->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ appendQuery('search', @$deposit->user->username) }}"><span>@</span>{{ $deposit->user->username }}</a>
                                            </span>
                                        </td>

                                        <td>
                                            {{ showDateTime($deposit->created_at) }}<br>{{ diffForHumans($deposit->created_at) }}
                                        </td>

                                        <td>
                                            {{ __($general->cur_sym) }}{{ showAmount($deposit->amount) }} + <span class="text-danger" title="@lang('charge')">{{ showAmount($deposit->charge) }} </span>
                                            <br>
                                            <strong title="@lang('Amount with charge')">
                                                {{ showAmount($deposit->amount + $deposit->charge) }} {{ __($general->cur_text) }}
                                            </strong>
                                        </td>

                                        <td>
                                            1 {{ __($general->cur_text) }} = {{ showAmount($deposit->rate) }} {{ __($deposit->method_currency) }}
                                            <br>
                                            <strong>{{ showAmount($deposit->final_amo) }} {{ __($deposit->method_currency) }}</strong>
                                        </td>

                                        <td> @php echo $deposit->statusBadge @endphp </td>

                                        <td>
                                            <a class="btn btn-sm btn-outline--primary ms-1" href="{{ route('admin.deposit.details', $deposit->id) }}">
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
                @if ($deposits->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($deposits) }}
                    </div>
                @endif
            </div><!-- card end -->
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')

    @if (!request()->routeIs('admin.users.deposits') && !request()->routeIs('admin.users.deposits.method'))
        @if (request()->routeIs('admin.deposit.list') || request()->routeIs('admin.branch.deposit.logs') || request()->routeIs('admin.branch.staff.deposit.logs'))
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
    @endif
@endpush
