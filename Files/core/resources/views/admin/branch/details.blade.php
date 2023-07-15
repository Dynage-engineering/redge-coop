@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-xxl-3 col-sm-6">
            <x-widget style="3" bg="success" color="white" icon="la la-wallet" title="Total Deposited" value="{{ $general->cur_sym }}{{ showAmount($widget['total_deposited']) }}" link="{{ route('admin.deposit.list') }}?branch={{ $branch->id }}" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style="3" bg="danger" color="white" icon="la la-hand-holding-usd" title="Total Withdrawn" value="{{ $general->cur_sym }}{{ showAmount($widget['total_withdrawals']) }}" link="{{ route('admin.withdraw.log') }}?branch={{ $branch->id }}" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style="3" bg="info" color="white" icon="la la-wallet" title="Total Account" value="{{ getAmount($widget['total_account']) }}" link="{{ route('admin.users.all') }}?branch={{ @$branch->id }}" />
        </div>

        <div class="col-xxl-3 col-sm-6">
            <x-widget style="3" bg="17" color="white" icon="la la-wallet" title="Total Staff" value="{{ getAmount($widget['total_staff']) }}" link="{{ route('admin.branch.staff.index') }}?branch={{ @$branch->id }}" />
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            @include('admin.branch.form')
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.branch.index') }}" />
@endpush
