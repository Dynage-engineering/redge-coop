@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @if ($general->modules->own_bank && $general->modules->other_bank)
                    <div class="d-flex flex-wrap gap-1 mb-3">
                        @if ($general->modules->own_bank)
                            <a href="javascript:void(0)" class="btn btn-md btn--base">@lang($general->site_name)</a>
                        @endif

                        @if ($general->modules->other_bank)
                            <a href="{{ route('user.beneficiary.other') }}" class="btn btn-md btn--dark">@lang('Other Banks')</a>
                        @endif
                    </div>
                @endif

                <div class="card custom--card mb-4 @if (!old('account_number')) d-none @endif" id="addForm">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">@lang('Add Beneficiary to') @lang($general->site_name)</h5>
                            <button type="button" class="btn btn-sm btn--danger close-form-btn"><i class="la la-times"></i></button>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('user.beneficiary.own.add') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label>@lang('Account Number')</label>
                                <input type="text" name="account_number" value="{{ old('account_number') }}" class="form--control" required>
                                <small class="text--danger error-message"></small>
                            </div>

                            <div class="form-group">
                                <label>@lang('Account Name')</label>
                                <input type="text" name="account_name" value="{{ old('account_name') }}" class="form--control" required>
                                <small class="text--danger error-message"></small>
                            </div>

                            <div class="form-group">
                                <label>@lang('Short Name')</label>
                                <input type="text" name="short_name" value="{{ old('short_name') }}" class="form--control" required>
                            </div>

                            <button type="submit" class="btn w-100 btn--base">@lang('Submit')</button>
                        </form>
                    </div>
                </div>

                <div class="table-responsive--md">
                    <div class="text-end">
                        <button type="button" class="btn btn-sm btn--dark add-btn mb-3"><i class="la la-plus-circle"></i> @lang('Add Beneficiary')</button>
                    </div>

                    <table class="table custom--table">
                        <thead>
                            <tr>
                                <th>@lang('Account Number')</th>
                                <th>@lang('Account Name')</th>
                                <th>@lang('Short Name')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($beneficiaries as $beneficiary)
                                <tr>
                                    <td>{{ $beneficiary->account_number }}</td>
                                    <td>{{ $beneficiary->account_name }}</td>
                                    <td>{{ $beneficiary->short_name }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%" class="text-center">{{ __($emptyMessage) }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($beneficiaries->hasPages())
                    {{ paginateLinks($beneficiaries) }}
                @endif

            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict';
        (function($) {
            const addForm = $('#addForm');

            $('.add-btn').on('click', function() {
                $(this).parent().hide();
                addForm.removeClass('d-none').hide().fadeIn(500);
            });

            $('.close-form-btn').on('click', function() {
                $('.add-btn').parent().show();
                addForm.hide();
            });

            addForm.on('focusout', '[name=account_number], [name=account_name]', function() {
                let $this = $(this);
                if ($this.val()) {
                    let route = `{{ route('user.beneficiary.check.account') }}`;
                    let data = {}

                    data.account_name = addForm.find('[name=account_name]').val();
                    data.account_number = addForm.find('[name=account_number]').val();

                    $.get(route, data, function(response) {
                        if (response.error) {
                            console.log($this);
                            $this.parent('.form-group').find('.error-message').text(response.message);
                        } else {
                            addForm.find('[name=account_number]').val(response.data.account_number);
                            addForm.find('[name=account_name]').val(response.data.account_name);
                            addForm.find('.error-message').empty();
                        }
                    });
                } else {
                    addForm.find('.error-message').empty();
                }
            });
        })(jQuery)
    </script>
@endpush

<x-transfer-bottom-menu />
