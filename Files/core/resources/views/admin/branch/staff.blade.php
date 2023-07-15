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
                                                <span class="fw-bold text--primary">@lang('Manager')</span>
                                            @else
                                                <span class="fw-bold text--info">@lang('Staff')</span>
                                            @endif
                                        </td>

                                        <td>{{ $staff->email }}</td>

                                        <td>{{ $staff->mobile }}</td>

                                        <td>@php echo $staff->statusBadge;@endphp</td>

                                        <td>
                                            <a class="btn btn-sm btn-outline--primary" data-resource="{{ $staff }}" href="{{ route('admin.branch.staff.details', $staff->id) }}">
                                                <i class="la la-pencil"></i>@lang('Edit')
                                            </a>

                                            @if ($staff->status)
                                                <button class="btn btn-sm confirmationBtn btn-outline--danger" data-action="{{ route('admin.branch.staff.status', $staff->id) }}" data-question="@lang('Are you sure to disable this branch?')" type="button">
                                                    <i class="la la-la la-eye-slash"></i>@lang('Disable')
                                                </button>
                                            @else
                                                <button class="btn btn-sm confirmationBtn btn-outline--success" data-action="{{ route('admin.branch.staff.status', $staff->id) }}" data-question="@lang('Are you sure to enable this branch?')" type="button">
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
    <x-search-form placeholder="Staff Email, Mobile" />

    <a class="btn btn-outline--primary h-45 ms-2" href="{{ route('admin.branch.staff.add') }}">
        <i class="la la-plus"></i>@lang('Add New')
    </a>
@endpush
