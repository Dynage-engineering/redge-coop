@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            @include('admin.branch.form')
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.branch.index') }}" />
@endpush
