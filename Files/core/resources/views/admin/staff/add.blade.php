@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            @include('admin.staff.form')
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.branch.staff.index') }}" />
@endpush
