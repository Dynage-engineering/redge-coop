@extends('branch_staff.layouts.app')
@section('panel')
    <div class="card b-radius--10">
        <div class="card-body">
            <form id="form" method="POST" action="{{ $action }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-xl-4">
                        <div class="form-group">
                            <label>@lang('Image')</label>
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview" style="background-image: url({{ getImage(getFilePath('userProfile') . '/' . @$account->image, getFileSize('userProfile'), true) }})">
                                            <button class="remove-image" type="button"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>

                                    <div class="avatar-edit">
                                        <input class="profilePicUpload" id="profilePicUpload1" name="image" type="file" accept=".png, .jpg, .jpeg" @if (!$account) required @endif>

                                        <label class="bg--primary" for="profilePicUpload1">@lang('Upload Image')</label>

                                        <small class="mt-2">@lang('Supported files'): <b>@lang('jpeg'), @lang('jpg'), @lang('png').</b> @lang('Image will be resized into '){{ getFileSize('userProfile') }} @lang('px') </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-8">
                        <div class="row">

                            <div class="col-xl-6 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('First Name')</label>
                                    <input class="form-control" name="firstname" type="text" value="{{ old('firstname', @$account->firstname) }}" required>
                                </div>
                            </div>

                            <div class="col-xl-6 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Last Name')</label>
                                    <input class="form-control" name="lastname" type="text" value="{{ old('lastname', @$account->lastname) }}" required>
                                </div>
                            </div>

                            <div class="col-xl-6 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Username')</label>
                                    <input class="form-control checkUser" name="username" type="text" value="{{ old('username', @$account->username) }}" required>
                                    <small class="text-danger usernameExist"></small>
                                </div>
                            </div>

                            <div class="col-xl-6 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('E-Mail Address')</label>
                                    <input class="form-control checkUser" name="email" type="email" value="{{ old('email', @$account->email) }}" required>
                                    <small class="text-danger emailExist"></small>
                                </div>
                            </div>

                            <div class="col-xl-6 col-sm-6">
                                <div class="form-group ">
                                    <label>@lang('Country')</label>
                                    <select name="country" class="form-control">
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}" value="{{ $key }}">{{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-xl-6 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Mobile Number') </label>
                                    <div class="input-group ">
                                        <span class="input-group-text mobile-code"></span>
                                        <input type="number" name="mobile" value="{{ old('mobile') }}" id="mobile" class="form-control checkUser" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('State')</label>
                                    <input class="form-control" name="state" type="text" value="{{ old('state', @$account->address->state) }}" required>
                                </div>
                            </div>

                            <div class="col-xl-4 col-sm-6">
                                <div class="form-group">
                                    <label>@lang('Zip Code')</label>
                                    <input class="form-control" name="zip" type="text" value="{{ old('zip', @$account->address->zip) }}" required>
                                </div>
                            </div>

                            <div class="col-xl-4 col-12">
                                <div class="form-group">
                                    <label>@lang('City')</label>
                                    <input class="form-control" name="city" type="text" value="{{ old('city', @$account->address->city) }}" required>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label>@lang('Address')</label>
                                    <input class="form-control" name="address" type="text" value="{{ old('address', @$account->address->address) }}" required>
                                </div>
                            </div>

                            @if (!$account && $general->modules->referral_system)
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>@lang('Referred By') <i class="fa fa-info-circle text--primary" title="@lang('Account number of the referrer')"></i></label>
                                        <input class="form-control" name="referrer" type="text" value="{{ old('referrer') }}">
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

                @if (!$account)
                    <h4 class="card-title my-3 text-center"> @lang('KYC Data')</h4>
                    <div class="row">
                        <x-viser-form identifier="act" identifierValue="kyc" />
                    </div>
                @endif

                <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict";
        (function($) {

            let mobileElement = $('.mobile-code');

            $('select[name=country]').change(function() {
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });

            if ('{{ @$account->country_code }}') {
                $('select[name=country]').val('{{ @$account->country_code }}');
            }

            let dialCode = $('select[name=country] :selected').data('mobile_code');
            let mobileNumber = `{{ @$account->mobile }}`;
            mobileNumber = mobileNumber.replace(dialCode, '');
            $('input[name=mobile]').val(mobileNumber);
            mobileElement.text(`+${dialCode}`);

            $('.checkUser').on('focusout', function(e) {


                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';

                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobile-code').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    };
                }

                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }

                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }

                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $(`.${response.type}Exist`).text(`This ${response.type} is already exist`);
                    } else {
                        $(`.${response.type}Exist`).empty();
                    }
                });
            });

        })(jQuery);
    </script>
@endpush
