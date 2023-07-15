<li><a class="{{ menuActive('user.home') }}" href="{{ route('user.home') }}">@lang('Dashboard')</a></li>

@if ($general->modules->deposit)
    <li> <a class="{{ menuActive('user.deposit*') }}" href="{{ route('user.deposit.history') }}">@lang('Deposit')</a></li>
@endif

@if ($general->modules->withdraw)
    <li><a class="{{ menuActive('user.withdraw*') }}" href="{{ route('user.withdraw.history') }}">@lang('Withdraw')</a></li>
@endif

@if ($general->modules->fdr)
    <li><a class="{{ menuActive('user.fdr*') }}" href="{{ route('user.fdr.plans') }}">@lang('FDR')</a></li>
@endif

@if ($general->modules->dps)
    <li><a class="{{ menuActive('user.dps*') }}" href="{{ route('user.dps.plans') }}">@lang('DPS')</a></li>
@endif

@if ($general->modules->loan)
    <li><a class="{{ menuActive('user.loan*') }}" href="{{ route('user.loan.plans') }}">@lang('Loan')</a></li>
@endif

@if ($general->modules->own_bank || $general->modules->other_bank || $general->modules->wire_transfer)
    @if ($general->modules->own_bank)
        <li>
            <a class="{{ menuActive(['user.transfer*', 'user.beneficiary.*']) }}" href="{{ route('user.beneficiary.own') }}">@lang('Transfer')</a>
        </li>
    @elseif($general->modules->other_bank)
        <li>
            <a class="{{ menuActive(['user.transfer*', 'user.beneficiary.*']) }}" href="{{ route('user.beneficiary.other') }}">@lang('Transfer')</a>
        </li>
    @else
        <li>
            <a class="{{ menuActive(['user.transfer*']) }}" href="{{ route('user.transfer.wire.index') }}">@lang('Transfer')</a>
        </li>
    @endif
@endif

<li>
    <a class="{{ menuActive(['user.profile.setting', 'user.twofactor', 'user.change.password', 'user.transaction.history', 'ticket', 'ticket.open', 'ticket.view']) }}" href="{{ route('user.profile.setting') }}">@lang('More')</a>
</li>
