@extends($activeTemplate . 'layouts.master')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card custom--card">
                    <div class="card-header bg-white">
                        <h5 class="card-title text-center">@lang('Deposit via') {{ __($data->gateway->name) }}</h5>
                    </div>
                    <div class="border-bottom">
                        <div class="mb-3 p-3">
                            <p class="text-center mt-2">@lang('You have requested') <b class="text--success">{{ showAmount($data['amount']) }} {{ __($general->cur_text) }}</b> , @lang('Please pay')
                                <b class="text--success">{{ showAmount($data['final_amo']) . ' ' . $data['method_currency'] }} </b> @lang('for successful payment')
                            </p>
                            <h4 class="text-center mb-2">@lang('Please follow the instruction below')</h4>
                            <p class="text-center">@php echo  $data->gateway->description @endphp</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.deposit.manual.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <x-viser-form identifier="id" identifierValue="{{ $data->gateway->form_id }}" />
                            <button type="submit" class="btn btn--base w-100">@lang('Pay Now')</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
