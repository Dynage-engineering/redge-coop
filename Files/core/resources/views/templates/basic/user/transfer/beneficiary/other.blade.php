@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @if ($general->modules->own_bank && $general->modules->other_bank)
                    <div class="d-flex flex-wrap gap-2 mb-3">

                        @if ($general->modules->own_bank)
                            <a href="{{ route('user.beneficiary.own') }}" class="btn btn-md btn--dark">@lang($general->site_name)</a>
                        @endif

                        @if ($general->modules->other_bank)
                            <a href="javascript:void(0)" class="btn btn-md btn--base">@lang('Other Banks')</a>
                        @endif
                    </div>
                @endif

                <div class="card custom--card mb-4 d-none" id="addForm">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">@lang('Add Beneficiary to Other Banks')</h5>

                            <button class="btn btn-sm btn--danger close-form" type="button"><i class="la la-times"></i></button>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <form action="{{ route('user.beneficiary.other.add') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>@lang('Select Bank')</label>
                                <select class="form--control" name="bank" required>
                                    <option value="" disabled selected>@lang('Select One')</option>
                                    @foreach ($otherBanks as $bank)
                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>@lang('Short Name')</label>
                                <input class="form--control" name="short_name" type="text" required>
                            </div>
                            <div id="user-fields">
                            </div>
                            <button class="btn w-100 btn--base" type="submit">@lang('Submit')</button>
                        </form>
                    </div>
                </div>

                <div class="table-responsive--md">
                    <div class="text-end">
                        <button class="btn btn-sm btn--dark add-btn mb-3" type="button"><i class="la la-plus-circle"></i> @lang('Add Beneficiary')</button>
                    </div>

                    <table class="custom--table table">
                        <thead>
                            <tr>
                                <th>@lang('Bank')</th>
                                <th>@lang('Account No.')</th>
                                <th>@lang('Account Name')</th>
                                <th>@lang('Short Name')</th>
                                <th>@lang('Details')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($beneficiaries as $beneficiary)
                                <tr>
                                    <td>{{ $beneficiary->beneficiaryOf->name }}</td>
                                    <td>{{ $beneficiary->account_number }}</td>
                                    <td>{{ $beneficiary->account_name }}</td>
                                    <td>{{ $beneficiary->short_name }}</td>
                                    <td>
                                        <button class="btn btn-sm btn--base seeDetails" data-id="{{ $beneficiary->id }}"><i class="la la-desktop"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">{{ __($emptyMessage) }}</td>
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

@push('modal')
    <div class="modal fade" id="detailsModal">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Benficiary Details')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <x-ajax-loader />
                </div>
            </div>
        </div>
    </div>
@endpush

@push('script')
    <script>
        'use strict';
        (function($) {
            const addForm = $('#addForm');

            $('.add-btn').on('click', function() {
                $(this).parent().hide();
                addForm.removeClass('d-none').hide().fadeIn(500);
            });

            $('.close-form').on('click', function() {
                $('.add-btn').parent().fadeIn(500);
                addForm.hide();
            });

            addForm.find('select[name=bank]').on('change', function() {
                let bankId = $(this).val();
                let action = `{{ route('user.beneficiary.other.bank.form.data', ':id') }}`;
                $.ajax({
                    url: action.replace(':id', bankId),
                    type: "GET",
                    dataType: 'json',
                    cache: false,
                    success: function(response) {
                        if (response.success) {
                            $('#user-fields').html(response.html).hide().fadeIn(500);
                        } else {
                            notify('error', response.message || `@lang('Something went the wrong')`)
                        }

                    },
                    error: function(e) {
                        notify(`@lang('Something went the wrong')`)
                    }
                });

            });

            $('.seeDetails').on('click', function() {
                let modal = $('#detailsModal');
                modal.find('.loading').removeClass('d-none');
                let action = `{{ route('user.beneficiary.details', ':id') }}`;
                let id = $(this).attr('data-id');
                $.ajax({
                    url: action.replace(':id', id),
                    type: "GET",
                    dataType: 'json',
                    cache: false,
                    success: function(response) {
                        if (response.success) {
                            modal.find('.loading').addClass('d-none');
                            modal.find('.modal-body').html(response.html);
                            modal.modal('show');
                        } else {
                            notify('error', response.message || `@lang('Something went the wrong')`)
                        }
                    },
                    error: function(e) {
                        notify(`@lang('Something went the wrong')`)
                    }
                });
            });
        })(jQuery)
    </script>
@endpush

<x-transfer-bottom-menu />
