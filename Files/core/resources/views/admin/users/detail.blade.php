@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4 mb-30">
        <div class="col-12">
            <div class="row gy-4">
                <div class="col-xxl-3 col-xl-8 col-sm-6">
                    <x-widget-2 color="info" icon="la la-money-bill-wave-alt" title="Balance" value="{{ $general->cur_sym }}{{ showAmount($user->balance) }}" link="{{ route('admin.report.transaction') }}?search={{ $user->username }}" overlay_icon=0 icon_style=solid />
                </div>

                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <x-widget-2 color="success" icon="la la-wallet" title="Deposited" value="{{ $general->cur_sym }}{{ showAmount($widget['total_deposit']) }}" link="{{ route('admin.deposit.list') }}?search={{ $user->username }}" overlay_icon=0 icon_style=solid />
                </div>

                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <x-widget-2 color="danger" icon="la la-wallet" title="Withdrawn" value="{{ $general->cur_sym }}{{ showAmount($widget['total_withdrawn']) }}" link="{{ route('admin.withdraw.log') }}?search={{ $user->username }}" overlay_icon=0 icon_style=solid />
                </div>

                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <x-widget-2 color="warning" icon="la la-exchange-alt" title="Total Transferred" value="{{ $general->cur_sym }}{{ showAmount($widget['total_transferred']) }}" link="{{ route('admin.transfers.index') }}?search={{ $user->username }}" overlay_icon=0 icon_style=solid />
                </div>

                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <x-widget-2 color="primary" icon="la la-money-bill" title="FDR" value="{{ $widget['total_fdr'] }}" link="{{ route('admin.fdr.index') }}?search={{ $user->username }}" overlay_icon=0 icon_style=solid />
                </div>

                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <x-widget-2 color="green" icon="la la-box" title="DPS" value="{{ $widget['total_dps'] }}" link="{{ route('admin.dps.index') }}?search={{ $user->username }}" overlay_icon=0 icon_style=solid />
                </div>

                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <x-widget-2 color="warning" icon="la la-hand-holding-usd" title="Loan" value="{{ $widget['total_loan'] }}" link="{{ route('admin.loan.index') }}?search={{ $user->username }}" overlay_icon=0 icon_style=solid />
                </div>

                <div class="col-xxl-3 col-xl-4 col-sm-6">
                    <x-widget-2 color="info" icon="la la-user-friends" title="Beneficiaries" value="{{ $widget['total_beneficiaries'] }}" link="{{ route('admin.users.beneficiaries', $user->id) }}" overlay_icon=0 icon_style=solid />
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="d-flex flex-wrap gap-3">
                <div class="flex-fill">
                    <button data-bs-toggle="modal" data-bs-target="#addSubModal" class="btn btn--success btn--shadow w-100 btn-lg bal-btn" data-act="add">
                        <i class="las la-plus-circle"></i> @lang('Balance')
                    </button>
                </div>

                <div class="flex-fill">
                    <button data-bs-toggle="modal" data-bs-target="#addSubModal" class="btn btn--danger btn--shadow w-100 btn-lg bal-btn" data-act="sub">
                        <i class="las la-minus-circle"></i> @lang('Balance')
                    </button>
                </div>

                <div class="flex-fill">
                    <a href="{{ route('admin.report.login.history') }}?search={{ $user->username }}" class="btn btn--primary btn--shadow w-100 btn-lg">
                        <i class="las la-list-alt"></i>@lang('Logins')
                    </a>
                </div>

                <div class="flex-fill">
                    <a href="{{ route('admin.users.notification.log', $user->id) }}" class="btn btn--secondary btn--shadow w-100 btn-lg">
                        <i class="las la-bell"></i>@lang('Notifications')
                    </a>
                </div>

                <div class="flex-fill">
                    <a href="{{ route('admin.users.login', $user->id) }}" target="_blank" class="btn btn--primary btn--gradi btn--shadow w-100 btn-lg">
                        <i class="las la-sign-in-alt"></i>@lang('Login as User')
                    </a>
                </div>

                @if ($user->kyc_data)
                    <div class="flex-fill">
                        <a href="{{ route('admin.users.kyc.details', $user->id) }}" target="_blank" class="btn btn--dark btn--shadow w-100 btn-lg">
                            <i class="las la-user-check"></i>@lang('KYC Data')
                        </a>
                    </div>
                @endif

                <div class="flex-fill">
                    @if ($user->status == Status::USER_ACTIVE)
                        <button type="button" class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal">
                            <i class="las la-ban"></i>@lang('Ban User')
                        </button>
                    @else
                        <button type="button" class="btn btn--success btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal">
                            <i class="las la-undo"></i>@lang('Unban User')
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4">
        <div class="col-xl-3 col-lg-5 col-md-5">
            <div class="row">
                <div class="col-6 col-sm-6 col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="card-title d-flex justify-content-center gap-3">
                                <h6>
                                    @if ($user->ev)
                                        <i class="la la-check-circle text--success"></i>
                                    @else
                                        <i class="la la-times-circle text--danger"></i>
                                    @endif
                                    @lang('Email')
                                </h6>
                                <h6>
                                    @if ($user->sv)
                                        <i class="la la-check-circle text--success"></i>
                                    @else
                                        <i class="la la-times-circle text--danger"></i>
                                    @endif
                                    @lang('Mobile')
                                </h6>
                                <h6>
                                    @if ($user->kv)
                                        <i class="la la-check-circle text--success"></i>
                                    @else
                                        <i class="la la-times-circle text--danger"></i>
                                    @endif
                                    @lang('KYC')
                                </h6>
                            </div>
                        </div>
                        <div class="card-body text-center">
                            <img class="account-holder-image rounded border w-100" src="{{ getImage(getFilePath('userProfile') . '/' . $user->image, null, true) }}" alt="account-holder-image">
                        </div>
                    </div>
                </div>

                <div class="col-6 col-sm-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title text-center">@lang('Basic Information')</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                    <small class="text-muted">@lang('Username')</small>
                                    <h6>{{ $user->username }}</h6>
                                </div>

                                <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                    <small class="text-muted">@lang('Account Number')</small>
                                    <h6>{{ $user->account_number }} </h6>
                                </div>

                                <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                    <small class="text-muted">@lang('Branch')</small>
                                    <h6>{{ $user->branch->name ?? 'Online' }} </h6>
                                </div>

                                @if ($user->referrer)
                                    <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                        <small class="text-muted">@lang('Referred By')</small>
                                        <a href="{{ route('admin.users.detail', $user->ref_by) }}">
                                            <h6 class="text--primary">{{ $user->referrer->username }}</h6>
                                        </a>
                                    </div>
                                @endif

                                @if ($user->branch)
                                    <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                        <small class="text-muted">@lang('Registered By')</small>
                                        <h6>{{ $user->branchStaff->name }} </h6>
                                    </div>
                                @endif

                                <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                    <small class="text-muted">@lang('Joined On')</small>
                                    <h6>{{ showDateTime($user->created_at, 'd M Y, h:i A') }} </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-9 col-lg-7 col-md-7">
            <div class="card">
                <div class="card-header d-flex flex-wrap justify-content-between">
                    <h5 class="card-title mb-0">@lang('Information of') {{ $user->fullname }}</h5>
                    <span>
                        @php echo $user->status_badge @endphp
                    </span>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-xl-6">
                                <div class="form-group ">
                                    <label>@lang('First Name')</label>
                                    <input class="form-control" type="text" name="firstname" required value="{{ $user->firstname }}">
                                </div>
                            </div>

                            <div class="col-lg-12 col-xl-6">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Last Name')</label>
                                    <input class="form-control" type="text" name="lastname" required value="{{ $user->lastname }}">
                                </div>
                            </div>

                            <div class="col-lg-12 col-xl-6">
                                <div class="form-group">
                                    <label>@lang('Email') </label>
                                    <input class="form-control" type="email" name="email" value="{{ $user->email }}" required>
                                </div>
                            </div>

                            <div class="col-lg-12 col-xl-6">
                                <div class="form-group">
                                    <label>@lang('Mobile Number') </label>
                                    <div class="input-group ">
                                        <span class="input-group-text mobile-code"></span>
                                        <input type="number" name="mobile" value="{{ old('mobile') }}" id="mobile" class="form-control checkUser" required>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-xl-6">
                                <div class="form-group">
                                    <label>@lang('City')</label>
                                    <input class="form-control" type="text" name="city" value="{{ @$user->address->city }}">
                                </div>
                            </div>

                            <div class="col-lg-12 col-xl-6">
                                <div class="form-group ">
                                    <label>@lang('State')</label>
                                    <input class="form-control" type="text" name="state" value="{{ @$user->address->state }}">
                                </div>
                            </div>

                            <div class="col-lg-12 col-xl-6">
                                <div class="form-group ">
                                    <label>@lang('Zip/Postal')</label>
                                    <input class="form-control" type="text" name="zip" value="{{ @$user->address->zip }}">
                                </div>
                            </div>

                            <div class="col-lg-12 col-xl-6">
                                <div class="form-group ">
                                    <label>@lang('Country')</label>
                                    <select name="country" class="form-control">
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}" value="{{ $key }}">{{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group ">
                                    <label>@lang('Address')</label>
                                    <input class="form-control" type="text" name="address" value="{{ @$user->address->address }}">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="form-group col-lg-6 col-xxl-3">
                                <label>@lang('Email Verification')</label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="ev" @if ($user->ev) checked @endif>

                            </div>

                            <div class="form-group col-lg-6 col-xxl-3">
                                <label>@lang('Mobile Verification')</label>
                                <input type="checkbox" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="sv" @if ($user->sv) checked @endif>

                            </div>
                            <div class="form-group col-lg-6 col-xxl-3">
                                <label>@lang('2FA Verification') </label>
                                <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Enable')" data-off="@lang('Disable')" name="ts" @if ($user->ts) checked @endif>
                            </div>
                            <div class="form-group col-lg-6 col-xxl-3">
                                <label>@lang('KYC') </label>
                                <input type="checkbox" data-width="100%" data-height="50" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" name="kv" @if ($user->kv == 1) checked @endif>
                            </div>
                        </div>

                        <button type="submit" class="btn btn--primary w-100 h-45 mt-3">@lang('Submit')
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Sub Balance MODAL --}}
    <div id="addSubModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span class="type"></span> <span>@lang('Balance')</span></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.users.add.sub.balance', $user->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="act">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Amount')</label>
                            <div class="input-group">
                                <input type="number" step="any" name="amount" class="form-control" placeholder="@lang('Please provide positive amount')" required>
                                <div class="input-group-text">{{ __($general->cur_text) }}</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>@lang('Remark')</label>
                            <textarea class="form-control" placeholder="@lang('Remark')" name="remark" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="userStatusModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if ($user->status == Status::USER_ACTIVE)
                            <span>@lang('Ban User')</span>
                        @else
                            <span>@lang('Unban User')</span>
                        @endif
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.users.status', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if ($user->status == Status::USER_ACTIVE)
                            <h6 class="mb-2">@lang('If you ban this user he/she won\'t able to access his/her dashboard.')</h6>
                            <div class="form-group">
                                <label>@lang('Reason')</label>
                                <textarea class="form-control" name="reason" rows="4" required></textarea>
                            </div>
                        @else
                            <p><span>@lang('Ban reason was'):</span></p>
                            <p>{{ $user->ban_reason }}</p>
                            <h4 class="text-center mt-3">@lang('Are you sure to unban this user?')</h4>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if ($user->status == Status::USER_ACTIVE)
                            <button type="submit" class="btn btn--primary h-45 w-100">@lang('Submit')</button>
                        @else
                            <button type="button" class="btn btn--dark" data-bs-dismiss="modal">@lang('No')</button>
                            <button type="submit" class="btn btn--primary">@lang('Yes')</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict";

            $('.bal-btn').click(function() {
                var act = $(this).data('act');
                $('#addSubModal').find('input[name=act]').val(act);
                if (act == 'add') {
                    $('.type').text('Add');
                } else {
                    $('.type').text('Subtract');
                }
            });

            let mobileElement = $('.mobile-code');

            $('select[name=country]').change(function() {
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });

            $('select[name=country]').val('{{ @$user->country_code }}');
            let dialCode = $('select[name=country] :selected').data('mobile_code');
            let mobileNumber = `{{ $user->mobile }}`;
            mobileNumber = mobileNumber.replace(dialCode, '');
            $('input[name=mobile]').val(mobileNumber);
            mobileElement.text(`+${dialCode}`);

        })(jQuery);
    </script>
@endpush
