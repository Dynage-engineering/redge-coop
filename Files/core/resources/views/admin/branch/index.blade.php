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
                                    <th>@lang('Name')</th>
                                    <th>@lang('Code')</th>
                                    <th>@lang('Address')</th>
                                    <th>@lang('Email') | @lang('Mobile')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($branches as $branch)
                                    <tr>
                                        <td>{{ $loop->index + $branches->firstItem() }}</td>
                                        <td>{{ __($branch->name) }}</td>
                                        <td>{{ $branch->code }}</td>
                                        <td>{{ strLimit(__($branch->address), 30) }}</td>
                                        <td>
                                            <span class="d-block">{{ @$branch->email }}</span>
                                            <span>{{ @$branch->mobile }}</span>
                                        </td>
                                        <td>
                                            @php echo $branch->statusBadge; @endphp
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <a href="{{ route('admin.branch.details', $branch->id) }}" class="btn btn-sm btn-outline--primary" data-resource="{{ $branch }}">
                                                    <i class="la la-desktop"></i>@lang('Details')
                                                </a>

                                                @if ($branch->status)
                                                    <button type="button" data-action="{{ route('admin.branch.status', $branch->id) }}" data-question="@lang('Are you sure to disable this branch?')" class="btn btn-sm confirmationBtn btn-outline--danger">
                                                        <i class="la la-la la-eye-slash"></i>@lang('Disable')
                                                    </button>
                                                @else
                                                    <button type="button" data-action="{{ route('admin.branch.status', $branch->id) }}" data-question="@lang('Are you sure to enable this branch?')" class="btn btn-sm confirmationBtn btn-outline--success">
                                                        <i class="la la-la la-eye"></i>@lang('Enable')
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
                @if ($branches->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($branches) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form />
    <a href="{{ route('admin.branch.add') }}" class="btn btn-outline--primary">
        <i class="las la-plus"></i>@lang('Add New')
    </a>
@endpush
