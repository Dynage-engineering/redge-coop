@extends('admin.layouts.app')
@section('panel')
    <div class="row gy-4">
        <div class="col-md-6">

            <div class="card mb-4">
                <div class="card-header text-end">
                    <small class="text-muted">
                        @lang('You may ENABLE or DISABLE the referral system from the') <a href="{{ route('admin.setting.system.configuration') }}">@lang('System Configuration')</a>
                    </small>
                </div>
                <div class="card-body">

                    <form action="{{ route('admin.referral.setting.count') }}" method="post">
                        @csrf
                        <label for="commission_count">@lang('Commission Count')</label>
                        <div class="input-group">
                            <input type="number" name="commission_count" id="commission_count" class="form-control" value="{{ @$general->referral_commission_count }}">
                            <span class="input-group-text">@lang('Times')</span>
                        </div>

                        <small class="text-muted"> <i class="la la-info-circle"></i> @lang('The number of times referrers will get the referral commission from a referee.')</small>

                        <button class="btn h-45 btn--primary w-100 mt-3">@lang('Submit')</button>
                    </form>
                </div>
            </div>

            <div class="card">
                @if ($levels->count())
                    <div class="card-header">
                        <h5 class="card-title">
                            @lang('Update Referral Level Setting')
                        </h5>
                    </div>
                @endif

                <div class="card-body parent">

                    <div class="input-group">
                        <input type="number" name="level" placeholder="@lang('Number of Level')" class="form-control levelGenerate">
                        <button type="button" class="input-group-text border-0 btn btn--primary btn-block generate">
                            @lang('Generate')
                        </button>
                    </div>

                    <form action="{{ route('admin.referral.setting') }}" method="post">
                        @csrf
                        <div class="d-none levelForm">
                            <div class="form-group">

                                @if ($levels->count())
                                    <label class="text--warning fw-bold"> @lang('Level & Commission :')
                                        @lang('(Old levels will be removed after generating new levels)')
                                    </label>
                                @endif

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="description referral-desc">
                                            <div class="row">
                                                <div class="col-md-12 planDescriptionContainer"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn--primary  w-100 h-45">@lang('Submit')</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        @if ($levels->count())
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive--sm ">
                            <table class="table table--light style--two">
                                <thead>
                                    <tr>
                                        <th>@lang('Level')</th>
                                        <th>@lang('Commission')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($levels as $key => $p)
                                        <tr>
                                            <td class="fw-bold">@lang('LEVEL') {{ $p->level }}</td>
                                            <td>{{ $p->percent }} %</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection

@push('script')
    <script>
        (function($) {
            "use strict";
            var max = 1;
            $(".generate").on('click', function() {
                var levelGenerate = $(this).parents('.parent').find('.levelGenerate').val();
                var html = '';

                if (levelGenerate !== '' && levelGenerate > 0) {
                    $(this).parents('.parent').find('.levelForm').removeClass('d-none');
                    $(this).parents('.parent').find('.levelForm').addClass('d-block');

                    for (let i = 1; i <= parseInt(levelGenerate); i++) {
                        html += `
                        <div class="input-group mt-4">
                            <span class="input-group-text no-right-border">LEVEL ${i}</span>
                            <input name="commission[${i}][level]" type="hidden" readonly value="${i}" required placeholder="Level">
                            <input name="commission[${i}][percent]" class="form-control margin-top-10" type="number" required placeholder="@lang('Commission Percentage')">
                            <span class="input-group-text">%</span>
                             <button class="input-group-text border-0 btn btn--danger margin-top-10 delete_desc" type="button"><i class='fa fa-times'></i></button>
                            </div>
                        </div>`;

                    }
                    $(this).parents('.parent').find('.planDescriptionContainer').html(html);

                } else {
                    alert('Level Field Is Required');
                }
            });

            $(document).on('click', '.delete_desc', function() {
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush
