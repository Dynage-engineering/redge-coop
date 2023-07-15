@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="benificiary-card">
                    <div class="nav nav-tabs mb-3">
                        <button class="nav-link active" data-name="own" data-bs-toggle="pill" data-bs-target="#own-bank" type="button" role="tab">@lang($general->site_name)
                        </button>
                        <button class="nav-link ms-3" data-name="other" data-bs-toggle="pill" data-bs-target="#other-bank" type="button" role="tab">@lang('Other Banks')
                        </button>
                    </div>

                    <div class="tab-content">
                        @include($activeTemplate . 'user.transfer.beneficiary.own_bank')
                        @include($activeTemplate . 'user.transfer.beneficiary.other_bank')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        'use strict';
        (function($) {
            const addForm = $('#addForm');
            const addOtherForm = $('#addOtherForm');

            $('.add-btn').on('click', function() {
                $(this).parent().hide();
                addForm.removeClass('d-none').hide().fadeIn(500);
            });

            $('.add-other-btn').on('click', function() {
                $(this).parent().hide();
                addOtherForm.removeClass('d-none').hide().fadeIn(500);
            });

            $('.close-form-btn').on('click', function() {
                $('.add-btn').parent().fadeIn(500);
                addForm.fadeOut(600);
            });

            $('.close-other-form').on('click', function() {
                $('.add-other-btn').parent().fadeIn(500);
                addOtherForm.fadeOut(500);
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

            addOtherForm.find('select[name=bank]').on('change', function() {
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

            $('.nav-link').on('click', function() {
                let name = $(this).data('name');
                localStorage.setItem('tabType', name);
            });

            function selectTab() {
                let tab = localStorage.getItem('tabType');
                if (tab) {
                    $('.nav-link').removeClass('active')
                    $('.tab-pane').removeClass('active')
                    if (tab == 'own') {
                        $('.nav-link[data-name=own]').addClass('active');
                        $('#own-bank').addClass('active show')
                    } else if (tab == 'other') {
                        $('.nav-link[data-name=other]').addClass('active')
                        $('#other-bank').addClass('active show')
                    }
                }
            }

            selectTab();

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

<x-transfer-bottom-menu />
