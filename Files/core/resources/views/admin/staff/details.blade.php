@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-xxl-4 col-md-4">
            <x-widget style="3" bg="success" color="white" icon="la la-wallet" title="Total Deposited" value="{{ $general->cur_sym }}{{ showAmount($widget['total_deposited']) }}" link="{{ route('admin.deposit.list') }}?staff={{ $staff->id }}" icon_style="outline" overlay_icon=0 />
        </div>

        <div class="col-xxl-4 col-md-4">
            <x-widget style="3" bg="danger" color="white" icon="la la-hand-holding-usd" title="Total Withdrawn" value="{{ $general->cur_sym }}{{ showAmount($widget['total_withdrawals']) }}" link="{{ route('admin.withdraw.log') }}?staff={{ $staff->id }}" />
        </div>

        <div class="col-xxl-4 col-md-4">
            <x-widget style="3" bg="info" color="white" icon="la la-users" title="Total User" value="{{ getAmount($widget['total_user']) }}" link="{{ route('admin.users.all') }}?staff={{ $staff->id }}" />
        </div>

    </div>
    <div class="row mt-4">
        <div class="col-12">
            @include('admin.staff.form')
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    @if ($staff->resume)
        <a class="btn btn-sm btn-outline--warning" href="{{ route('admin.download.attachment', encrypt(getFilePath('branchStaff') . '/' . $staff->resume)) }}">
            <i class="las la-download"></i> @lang('Resume')
        </a>
    @endif

    <a class="btn btn-sm btn-outline--primary" href="{{ route('admin.branch.staff.login', $staff->id) }}" target="_blank">
        <i class="las la-sign-in-alt"></i>@lang('Login as ') {{ $staff->designation == 1 ? 'Manager' : 'Staff' }}
    </a>
@endpush
