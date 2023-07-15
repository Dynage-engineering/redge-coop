@extends('branch_staff.layouts.master')

@section('content')
    <div class="page-wrapper default-version">
        @include('branch_staff.partials.sidenav')
        @include('branch_staff.partials.topnav')
        <div class="body-wrapper">
            <div class="bodywrapper__inner">
                @include('branch_staff.partials.breadcrumb')
                @yield('panel')
            </div>
        </div>
    </div>
@endsection
