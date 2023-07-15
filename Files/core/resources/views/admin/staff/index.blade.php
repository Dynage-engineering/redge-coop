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
                                    <th>@lang('Name')</th>
                                    <th>@lang('Designation')</th>
                                    <th>@lang('Email')</th>
                                    <th>@lang('Mobile')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($staffs as $staff)
                                    <tr>
                                        <td>{{ $loop->index + $staffs->firstItem() }}</td>

                                        <td>{{ $staff->name }}</td>

                                        <td>
                                            @if ($staff->designation)
                                                @php $branch = implode(', ', $staff->assignBranch->pluck('name')->toArray());@endphp

                                                <span class="fw-bold text--primary" title="{{ $branch }}">@lang('Manager')</span>
                                            @else
                                                <span class="fw-bold text--info">@lang('Account Officer')</span>
                                            @endif
                                        </td>

                                        <td>{{ $staff->email }}</td>

                                        <td>{{ $staff->mobile }}</td>

                                        <td>@php echo $staff->statusBadge;@endphp</td>

                                        <td>
                                            <div class="button--group">
                                                <a class="btn btn-sm btn-outline--primary" data-resource="{{ $staff }}" href="{{ route('admin.branch.staff.details', $staff->id) }}">
                                                    <i class="la la-desktop"></i>@lang('Details')
                                                </a>

                                                @if ($staff->status)
                                                    <button class="btn btn-sm confirmationBtn btn-outline--danger" data-action="{{ route('admin.branch.staff.status', $staff->id) }}" data-question="@lang('Are you sure to ban this staff?')" type="button">
                                                        <i class="las la-user-alt-slash"></i>@lang('Ban')
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm confirmationBtn btn-outline--success" data-action="{{ route('admin.branch.staff.status', $staff->id) }}" data-question="@lang('Are you sure to unban this staff?')" type="button">
                                                        <i class="las la-user-check"></i>@lang('Unban')
                                                    </button>
                                                @endif
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
                @if ($staffs->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($staffs) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <div class="btn-group">
        <button class="btn btn-outline--primary dropdown-toggle" data-bs-toggle="dropdown" type="button">
            @if (request()->branch)
                @php $branch = $branches->where('name', request()->branch)->first(); @endphp
                {{ @$branch->name }}
            @else
                @lang('All Branch')
            @endif
        </button>

        <ul class="dropdown-menu">
            <li>
                <a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['branch' => null]) }}">@lang('All Branch')</a>
            </li>
            @foreach ($branches as $branch)
                <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['branch' => $branch->name]) }}">{{ __($branch->name) }}</a></li>
            @endforeach
        </ul>
    </div>
    <div class="btn-group">
        <button class="btn btn-outline--primary dropdown-toggle" data-bs-toggle="dropdown" type="button">
            @if (request()->designation == 'manager')
                @lang('Manager')
            @elseif(request()->designation == 'account_officer')
                @lang('Account Officer')
            @else
                @lang('All Staff')
            @endif
        </button>

        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['designation' => null]) }}">@lang('All')</a></li>
            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['designation' => 'manager']) }}">@lang('Manager')</a></li>
            <li><a class="dropdown-item" href="{{ request()->fullUrlWithQuery(['designation' => 'account_officer']) }}">@lang('Account Officer')</a></li>
        </ul>
    </div>
    <x-search-form placeholder="Email, Mobile" />
    <a class="btn btn-outline--primary h-45 ms-2" href="{{ route('admin.branch.staff.add') }}">
        <i class="la la-plus"></i>@lang('Add New')
    </a>
@endpush
