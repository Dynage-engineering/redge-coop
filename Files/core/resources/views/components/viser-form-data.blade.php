@props([
    'title' => 'User Data',
    'form' => null,
])

<div class="card mt-3">

    <div class="card-header d-flex justify-content-between">
        <h5 class="card-title">{{ __(@$title) }}</h5>
        <button type="button" class="btn btn-sm btn-outline--primary float-end form-generate-btn">
            <i class="la la-fw la-plus"></i>@lang('Add New')
        </button>
    </div>

    <div class="card-body">
        <div class="row addedField">
            @if (@$form)
                @foreach ($form->form_data as $formData)
                    <div class="col-md-4">
                        <div class="card border mb-3" id="{{ $loop->index }}">
                            <input type="hidden" name="form_generator[is_required][]" value="{{ $formData->is_required }}">
                            <input type="hidden" name="form_generator[extensions][]" value="{{ $formData->extensions }}">
                            <input type="hidden" name="form_generator[options][]" value="{{ implode(',', $formData->options) }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>@lang('Label')</label>
                                    <input type="text" name="form_generator[form_label][]" class="form-control" value="{{ $formData->name }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>@lang('Type')</label>
                                    <input type="text" name="form_generator[form_type][]" class="form-control" value="{{ $formData->type }}" readonly>
                                </div>
                                @php
                                    $jsonData = getFormData($formData);
                                @endphp
                                @if (!@$formData->default)
                                    <div class="btn-group w-100">
                                        <button type="button" class="btn btn--primary editFormData" data-form_item="{{ $jsonData }}" data-update_id="{{ $loop->index }}">
                                            <i class="las la-pen"></i>
                                        </button>
                                        <button type="button" class="btn btn--danger removeFormData">
                                            <i class="las la-times"></i>
                                        </button>
                                    </div>
                                @else
                                    <div class="bg--danger w-100 p-1 rounded text-center"> @lang('Must be Required')</div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

@push('script')
    <script>
        "use strict"
        var formGenerator = new FormGenerator();
        formGenerator.totalField = {{ @$form ? count((array) $form->form_data) : 0 }}
    </script>

    <script src="{{ asset('assets/global/js/form_actions.js') }}"></script>
@endpush
