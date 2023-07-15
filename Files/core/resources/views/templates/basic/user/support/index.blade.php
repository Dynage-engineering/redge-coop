@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="mb-3 text-end">
            <a class="btn btn-sm btn--base" href="{{ route('ticket.open') }}">
                <i class="las la-plus"></i>
                @lang('Create Ticket')
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive--md">
                            <table class="custom--table table">
                                <thead>
                                    <tr>
                                        <th>@lang('S.N.')</th>
                                        <th>@lang('Subject')</th>
                                        <th>@lang('Status')</th>
                                        <th>@lang('Priority')</th>
                                        <th>@lang('Last Reply')</th>
                                        <th>@lang('Action')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($supports as $support)
                                        <tr>
                                            <td>{{ $loop->index + $supports->firstItem() }}</td>

                                            <td>
                                                <a class="fw-bold" href="{{ route('ticket.view', $support->ticket) }}"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a>
                                            </td>

                                            <td>@php echo $support->statusBadge; @endphp</td>

                                            <td>
                                                @if ($support->priority == Status::PRIORITY_LOW)
                                                    <span class="badge badge--dark">@lang('Low')</span>
                                                @elseif($support->priority == Status::PRIORITY_MEDIUM)
                                                    <span class="badge badge--warning">@lang('Medium')</span>
                                                @elseif($support->priority == Status::PRIORITY_HIGH)
                                                    <span class="badge badge--danger">@lang('High')</span>
                                                @endif
                                            </td>

                                            <td>{{ \Carbon\Carbon::parse($support->last_reply)->diffForHumans() }} </td>

                                            <td>
                                                <a class="btn btn-outline--base btn-sm" href="{{ route('ticket.view', $support->ticket) }}">
                                                    <i class="la la-desktop"></i> @lang('View')
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($supports->hasPages())
                        <div class="card-footer">
                            {{ paginateLinks($supports) }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('bottom-menu')
    <li><a href="{{ route('user.profile.setting') }}">@lang('Profile')</a></li>
    <li><a href="{{ route('user.referral.users') }}">@lang('Referral')</a></li>
    <li><a href="{{ route('user.twofactor') }}">@lang('2FA Security')</a></li>
    <li><a href="{{ route('user.change.password') }}">@lang('Change Password')</a></li>
    <li><a href="{{ route('user.transaction.history') }}">@lang('Transactions')</a></li>
    <li><a class="active" href="{{ route('ticket.index') }}">@lang('Support Tickets')</a></li>
@endpush
