@push('bottom-menu')
    @if (@$general->modules->own_bank || @$general->modules->other_bank || $general->modules->wire_transfer)
        @if ($general->modules->own_bank)
            <li>
                <a class="{{ menuActive(['user.beneficiary.own', 'user.beneficiary.other']) }}" href="{{ route('user.beneficiary.own') }}">@lang('Beneficiaries')</a>
            </li>
        @elseif ($general->modules->other_bank)
            <li>
                <a class="{{ menuActive(['user.beneficiary.own', 'user.beneficiary.other']) }}" href="{{ route('user.beneficiary.other') }}">@lang('Beneficiaries')</a>
            </li>
        @endif

        @if (@$general->modules->own_bank)
            <li>
                <a href="{{ route('user.transfer.own.bank.beneficiaries') }}" class="{{ menuActive('user.transfer.own.bank.beneficiaries') }}">
                    @lang('Within') @lang($general->site_name)</a>
            </li>
        @endif

        @if (@$general->modules->other_bank)
            <li><a href="{{ route('user.transfer.other.bank.beneficiaries') }}" class="{{ menuActive('user.transfer.other.bank.beneficiaries') }}">
                    @lang('Other Bank')
                </a>
            </li>
        @endif

        @if (@$general->modules->wire_transfer)
            <li>
                <a href="{{ route('user.transfer.wire.index') }}" class="{{ menuActive('user.transfer.wire.index') }}">
                    @lang('Wire Transfer')
                </a>
            </li>
        @endif

        <li>
            <a href="{{ route('user.transfer.history') }}" class="{{ menuActive('user.transfer.history') }}">
                @lang('History')
            </a>
        </li>
    @endif
@endpush
