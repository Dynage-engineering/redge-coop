@extends('branch_staff.layouts.app')
@section('panel')
    <div class="row justify-content-center gy-4">
        <div class="col-xxl-9 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('staff.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row justify-center">
                            <div class="col-xl-4 col-md-5 col-sm-6">
                                <div class="image-upload mb-3">
                                    <label>@lang('Image')</label>
                                    <div class="thumb">
                                        <div class="avatar-preview">
                                            <div class="profilePicPreview" style="background-image: url({{ getImage(getFilePath('branchStaffProfile') . '/' . $staff->image, getFileSize('branchStaffProfile')) }})">
                                                <button type="button" class="remove-image"><i class="fa fa-times"></i></button>
                                            </div>
                                        </div>
                                        <div class="avatar-edit">
                                            <input type="file" class="profilePicUpload" name="image" id="profilePicUpload1" accept=".png, .jpg, .jpeg">

                                            <label for="profilePicUpload1" class="bg--primary">@lang('Upload Image')</label>

                                            <small class="mt-2 text-muted">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg').</b> @lang('Image will be resized into 400x400px') </small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-8 col-md-7 col-sm-6">
                                <div class="form-group ">
                                    <label>@lang('Name')</label>
                                    <input class="form-control" type="text" name="name" value="{{ $staff->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Email')</label>
                                    <input class="form-control" type="email" name="email" value="{{ $staff->email }}" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Mobile')</label>
                                    <input class="form-control" type="text" name="mobile" value="{{ $staff->mobile }}" required>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Address')</label>
                                    <input class="form-control" type="text" name="address" value="{{ $staff->address }}" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
