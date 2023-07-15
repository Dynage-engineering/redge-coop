@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-xxl-3 col-xl-4 col-lg-5 col-md-5">
            <div class="card b-radius--5 overflow-hidden">
                <div class="d-flex p-3 bg--primary align-items-center">
                    <div class="avatar avatar--lg">
                        <img src="{{ getImage(getFilePath('adminProfile') . '/' . $admin->image) }}" alt="@lang('Image')">
                    </div>
                    <h5 class="text--white ps-3">{{ __($admin->name) }}</h5>
                </div>
                <div class="card-body px-0">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Name')
                            <span class="fw-bold">{{ __($admin->name) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Username')
                            <span class="fw-bold">{{ __($admin->username) }}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            @lang('Email')
                            <span class="fw-bold">{{ $admin->email }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-xxl-9 col-xl-8 col-lg-7 col-md-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">@lang('Change Password')</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.password.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>@lang('Password')</label>
                            <input class="form-control" type="password" name="old_password" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('New Password')</label>
                            <input class="form-control" type="password" name="password" required>
                        </div>

                        <div class="form-group">
                            <label>@lang('Confirm Password')</label>
                            <input class="form-control" type="password" name="password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn--primary w-100 btn-lg h-45">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.profile') }}" class="btn btn-sm btn-outline--primary"><i class="las la-user"></i>@lang('Profile Setting')</a>
@endpush
