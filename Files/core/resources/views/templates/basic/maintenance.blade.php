@extends($activeTemplate . 'layouts.app')
@section('main-content')
    <div class="maintenance-page flex-column justify-content-center">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-8 text-center">
                    <div class="row justify-content-center">
                        <div class="col-xl-10 mb-3">
                            <h4 class="text--danger">{{ __(@$maintenance->data_values->heading) }}</h4>
                        </div>

                    </div>
                    <p class="mx-auto text-center">@php echo $maintenance->data_values->description @endphp</p>
                </div>
            </div>
        </div>
    </div>
@endsection
