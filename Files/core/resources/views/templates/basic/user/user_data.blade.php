@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <div class="container pt-80 pb-80">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card custom--card">
                    <div class="card-body">
                        <div class="alert alert-warning" role="alert">
                            <strong> <i class="la la-info-circle"></i> @lang('You need to complete your profile to get access to your dashboard')</strong>
                        </div>
                        <form method="POST" action="{{ route('user.data.submit') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="form-group col-sm-6">
                                    <label class="form-label required">@lang('First Name')</label>
                                    <input type="text" class="form--control" name="firstname" value="{{ old('firstname') }}" required>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label required">@lang('Last Name')</label>
                                    <input type="text" class="form--control" name="lastname" value="{{ old('lastname') }}" required>
                                </div>

                                <div class="form-group col-12">
                                    <label class="form-label required">@lang('Image')</label>
                                    <input type="file" class="form--control" name="image" id="imageUpload" value="{{ old('firstname') }}" accept=".png, .jpg, .jpeg" required>
                                    <div class="proifle-image-preview d-none"><img src="" alt="profile-image"></div>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label class="form-label">@lang('Address')</label>
                                    <input type="text" class="form--control" name="address" value="{{ old('address') }}">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">@lang('State')</label>
                                    <input type="text" class="form--control" name="state" value="{{ old('state') }}">
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">@lang('Zip Code')</label>
                                    <input type="text" class="form--control" name="zip" value="{{ old('zip') }}">
                                </div>

                                <div class="form-group col-sm-6">
                                    <label class="form-label">@lang('City')</label>
                                    <input type="text" class="form--control" name="city" value="{{ old('city') }}">
                                </div>
                            </div>

                            <button type="submit" class="btn btn-md btn--base w-100">
                                @lang('Submit')
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .proifle-image-preview {
            margin-top: 15px;
        }

        .proifle-image-preview img {
            width: 200px;
            height: 160px;
        }
    </style>
@endpush

@push('script')
    <script>
        $("#imageUpload").on('change', function() {
            if (this.files && this.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('.proifle-image-preview').removeClass('d-none');
                    $('.proifle-image-preview img').attr('src', e.target.result)
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
@endpush
