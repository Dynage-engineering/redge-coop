@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">

                    <div class="card-body">
                        @if ($user->kyc_data)
                            @if (!$user->kv)
                                <div class="alert alert-warning" role="alert">
                                    <p>@lang('You have submitted the below information to be verified. Please wait for admin approval.')</p>
                                </div>
                            @endif

                            <ul class="list-group list-group-flush">
                                @foreach ($user->kyc_data as $val)
                                    @continue(!$val->value)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{ __($val->name) }}
                                        <span>
                                            @if ($val->type == 'checkbox')
                                                {{ implode(',', $val->value) }}
                                            @elseif($val->type == 'file')
                                                <a href="{{ route('user.download.attachment', encrypt(getFilePath('verify') . '/' . $val->value)) }}" class="ms-3"><i class="fa fa-file"></i> @lang('View File') </a>
                                            @else
                                                <p>{{ __($val->value) }}</p>
                                            @endif
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <h5 class="text-center">@lang('KYC data not found')</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
