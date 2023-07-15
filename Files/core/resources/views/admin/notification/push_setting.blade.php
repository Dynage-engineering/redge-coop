@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-md-12">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <form action="{{ route('admin.setting.notification.push.setting') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('API Key')</label>
                                    <input class="form-control" name="apiKey" type="text" value="{{ @$general->push_configuration->apiKey }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Auth Domain')</label>
                                    <input class="form-control" name="authDomain" type="text" value="{{ @$general->push_configuration->authDomain }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Project ID')</label>
                                    <input class="form-control" name="projectId" type="text" value="{{ @$general->push_configuration->projectId }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Storage Bucket')</label>
                                    <input class="form-control" name="storageBucket" type="text" value="{{ @$general->push_configuration->storageBucket }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Messageing Sender ID')</label>
                                    <input class="form-control" name="messagingSenderId" type="text" value="{{ @$general->push_configuration->messagingSenderId }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('App ID')</label>
                                    <input class="form-control" name="appId" type="text" value="{{ @$general->push_configuration->appId }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Measurment ID')</label>
                                    <input class="form-control" name="measurementId" type="text" value="{{ @$general->push_configuration->measurementId }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Server Key')</label>
                                    <input class="form-control" name="serverKey" type="text" value="{{ @$general->push_configuration->serverKey }}" required>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn--primary h-45 w-100" type="submit">@lang('Submit')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
