@if ($general->modules->loan)
    @php
        $content = getContent('loan_plans.content', true);
        $plans = App\Models\LoanPlan::active()
            ->latest()
            ->limit(3)
            ->get();
    @endphp
    @if ($content && $plans->count())
        <section class="pt-80 pb-80">
            <div class="container-md">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-7">
                        <div class="section-header text-center">
                            <div class="section-top-title border-left custom--cl">{{ __(@$content->data_values->title) }}</div>
                            <h2 class="section-title">{{ __(@$content->data_values->heading) }}</h2>
                        </div>
                    </div>
                </div>
                @include($activeTemplate . 'partials.loan_plans')

                <div class="text-center mt-4">
                    <a href="{{ route('user.loan.plans') }}" class="btn btn--base">@lang('View All')</a>
                </div>
            </div>
        </section>
    @endif
@endif
