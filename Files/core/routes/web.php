<?php

use App\Models\Form;
use App\Models\Loan;
use App\Models\LoanPlan;
use Illuminate\Support\Facades\Route;

Route::get('/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::get('/import-loan-installments', function () {
    $loans = Loan::whereRaw('given_installment != total_installment')->withCount('installments')->get();

    $data = [];
    foreach ($loans as $loan) {
        $installmentDiteHobe = $loan->total_installment - $loan->given_installment;

        $firstInstallmentDate = $loan->created_at->addDays($loan->installment_interval);

        for ($i = 0; $i < $installmentDiteHobe; $i++) {
            $installmentDate                     = $firstInstallmentDate;
            $installment['installmentable_id']   = $loan->id;
            $installment['installmentable_type'] = Loan::class;
            $installment['installment_date']     = $installmentDate->format('Y-m-d');
            $installment['given_at']             = null;
            $installment['delay_charge']         = 0;
            $data[]                              = $installment;
            $firstInstallmentDate                = $installmentDate->addDays($loan->installment_interval);
        }
    }

    // Installment::insert($data);
});

Route::get('/loan-plans', function () {
    $loanPlan = LoanPlan::get();
    foreach ($loanPlan as $plan) {
        $i = 0;
        foreach (json_decode($plan->requirement_information) as $info) {
            $label            = titleToKey($info->field_name);
            $formData[$label] = [
                'name'        => $info->field_name,
                'label'       => $label,
                'is_required' => $info->validation,
                'extensions'  => "",
                'options'     => [],
                'type'        => $info->type,
            ];
            $i++;
        }
        $form            = new Form();
        $form->act       = 'loan_plan';
        $form->form_data = $formData;
        $form->save();

        $plan->form_id = $form->id;
        $plan->save();
    }
});

// Cron Route
Route::get('cron/dps', 'CronController@dps')->name('cron.dps');
Route::get('cron/fdr', 'CronController@fdr')->name('cron.fdr');
Route::get('cron/loan', 'CronController@loan')->name('cron.loan');

// User Support Ticket
Route::controller('TicketController')->prefix('ticket')->name('ticket.')->group(function () {
    Route::get('/', 'supportTicket')->name('index');
    Route::get('new', 'openSupportTicket')->name('open');
    Route::post('create', 'storeSupportTicket')->name('store');
    Route::get('view/{ticket}', 'viewTicket')->name('view');
    Route::post('reply/{ticket}', 'replyTicket')->name('reply');
    Route::post('close/{ticket}', 'closeTicket')->name('close');
    Route::get('download/{ticket}', 'ticketDownload')->name('download');
});

Route::get('app/deposit/confirm/{hash}', 'Gateway\PaymentController@appDepositConfirm')->name('deposit.app.confirm');

Route::controller('SiteController')->group(function () {

    Route::post('check-mail', 'checkUser')->name('user.checkUser');
    Route::post('/subscribe', 'addSubscriber')->name('subscribe');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('registration/disabled', 'registrationDisabled')->name('registration.disabled');
    Route::post('/contact', 'contactSubmit');
    Route::get('/change/{lang?}', 'changeLanguage')->name('lang');
    Route::get('cookie-policy', 'cookiePolicy')->name('cookie.policy');
    Route::get('/cookie/accept', 'cookieAccept')->name('cookie.accept');
    Route::get('blog/{slug}/{id}', 'blogDetails')->name('blog.details');
    Route::get('policy/{slug}/{id}', 'policyPages')->name('policy.pages');
    Route::get('placeholder-image/{size}', 'placeholderImage')->name('placeholder.image');

    Route::get('/branches', 'branches')->name('branches');
    Route::post('device/token', 'storeDeviceToken')->name('store.device.token');

    Route::get('/{slug}', 'pages')->name('pages');
    Route::get('/', 'index')->name('home');
});
