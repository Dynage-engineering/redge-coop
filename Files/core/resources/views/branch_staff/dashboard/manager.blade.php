@extends('branch_staff.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-xl-4 col-md-6 col-12">
            <x-widget style="2" bg="white" color="danger" icon="la la-map-marker" title="{{ @$branch->address }}" value="{{ @$branch->name }} Branch" icon_style="solid" />
        </div>

        <div class="col-xl-4 col-md-6 col-12">
            <x-widget style="2" bg="white" color="success" icon="la la-wallet" value="{{ $general->cur_sym }}{{ showAmount($depositedAmount) }}" title="Deposited Today" icon_style="solid" />
        </div>

        <div class="col-xl-4 col-md-6 col-12">
            <x-widget style="2" bg="white" color="warning" icon="la la-hand-holding-usd" value="{{ $general->cur_sym }}{{ showAmount($withdrawnAmount) }}" title="Withdrawn Today" icon_style="solid" />
        </div>
    </div>

    <h5 class="card-title mt-5 d-flex justify-content-between">
        @lang('Latest Transactions')
        <a href="{{ route('staff.transactions') }}" class="btn btn-outline--primary">@lang('View All')</a>
    </h5>
    <div class="row gy-4">
        <div class="col-col-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    @include('branch_staff.partials.transaction_table')
                </div>
            </div>
        </div>
    </div>
@endsection
