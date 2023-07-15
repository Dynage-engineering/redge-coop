<?php

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::namespace ('Api')->name('api.')->group(function () {

    Route::get('general-setting', function () {
        $general  = GeneralSetting::first();
        $notify[] = 'General setting data';
        return response()->json([
            'remark'  => 'general_setting',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'general_setting' => $general,
            ],
        ]);
    });

    Route::get('get-countries', function () {
        $c        = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $notify[] = 'General setting data';
        foreach ($c as $k => $country) {
            $countries[] = [
                'country'      => $country->country,
                'dial_code'    => $country->dial_code,
                'country_code' => $k,
            ];
        }
        return response()->json([
            'remark'  => 'country_data',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'countries' => $countries,
            ],
        ]);
    });

    Route::namespace ('Auth')->group(function () {
        Route::post('login', 'LoginController@login');
        Route::post('register', 'RegisterController@register');
        Route::get('logout', 'LoginController@logout')->middleware('auth:sanctum');

        Route::controller('ForgotPasswordController')->group(function () {
            Route::post('password/email', 'sendResetCodeEmail');
            Route::post('password/verify-code', 'verifyCode');
            Route::post('password/reset', 'reset');
        });
    });

    Route::middleware('auth:sanctum')->group(function () {

        //authorization
        Route::controller('AuthorizationController')->group(function () {
            Route::get('authorization', 'authorization');
            Route::get('resend-verify/{type}', 'sendVerifyCode');
            Route::post('verify-email', 'emailVerification');
            Route::post('verify-mobile', 'mobileVerification');
            Route::post('verify-g2fa', 'g2faVerification');
        });

        Route::middleware(['check.status'])->group(function () {
            Route::post('user-data-submit', 'UserController@userDataSubmit')->name('data.submit');
            Route::post('get/device/token', 'UserController@getDeviceToken')->name('get.device.token');

            Route::middleware('registration.complete')->group(function () {

                Route::controller('UserController')->group(function () {
                    Route::get('dashboard', 'dashboard');
                    Route::get('user-info', 'userInfo');
                    Route::get('referral-link', 'referralLink');

                    //KYC
                    Route::get('kyc-form', 'kycForm');
                    Route::post('kyc-submit', 'kycSubmit');
                    Route::get('kyc-data', 'kycData');

                    //Report
                    Route::any('deposit/history', 'depositHistory');
                    Route::get('transactions', 'transactions');
                    Route::get('transfer/history', 'transferHistory');
                    Route::get('notification/history', 'notificationHistory');
                    Route::get('notification/detail/{id}', 'notificationDetail');
                });

                //Profile setting
                Route::controller('UserController')->group(function () {
                    Route::post('profile-setting', 'submitProfile');
                    Route::post('change-password', 'submitPassword');
                });

                Route::middleware('checkModule:referral_system')->controller('UserController')->group(function () {
                    Route::get('referees', 'referredUsers');
                });
                // Withdraw
                Route::middleware('checkModule:withdraw')->controller('WithdrawController')->name('withdraw.')->group(function () {
                    Route::middleware('kyc')->group(function () {
                        Route::get('withdraw-method', 'withdrawMethod');
                        Route::post('apply', 'apply');
                        Route::get('withdraw/store/{id}', 'withdrawStore')->name('store');
                        Route::get('withdraw/preview/{trx}', 'withdrawPreview');
                        Route::post('withdraw-request/confirm/{trx}', 'withdrawSubmit');
                    });
                    Route::get('withdraw/history', 'withdrawLog');
                });

                // Payment
                Route::controller('PaymentController')->group(function () {
                    Route::get('deposit/methods', 'methods');
                    Route::post('deposit/insert', 'depositInsert');
                    Route::get('deposit/confirm', 'depositConfirm');
                    Route::get('deposit/manual', 'manualDepositConfirm');
                    Route::post('deposit/manual', 'manualDepositUpdate');
                });

                Route::controller('OtpController')->group(function () {
                    Route::post('check/otp/{id}', 'submitOTP');
                    Route::post('resend/otp/{id}', 'resendOtp');
                });

                Route::middleware('checkModule:fdr')->controller('FdrController')->name('fdr.')->prefix('fdr')->group(function () {
                    Route::get('list', 'list');
                    Route::get('plans', 'plans');
                    Route::post('apply/{id}', 'apply');
                    Route::get('preview/{id}', 'preview')->name('apply.preview');;
                    Route::post('confirm/{id}', 'confirm');
                    Route::post('close/{id}', 'close')->name('close');
                    Route::get('instalment/logs/{fdr_number}', 'installments');
                });

                //====================start user dps route ==================//
                Route::middleware('checkModule:dps')->controller('DpsController')->name('dps.')->prefix('dps')->group(function () {
                    Route::get('plans', 'plans');
                    Route::post('apply/{id}', 'apply');
                    Route::get('preview/{id}', 'preview')->name('apply.preview');
                    Route::post('confirm/{id}', 'confirm');
                    Route::get('list', 'list');
                    Route::post('withdraw/{id}', 'withdraw');
                    Route::get('instalment/logs/{dps_number}', 'installments');
                });

                //=================start user loan route ====================///
                Route::middleware('checkModule:loan')->controller('LoanController')->prefix('loan')->group(function () {
                    Route::get('plans', 'plans');
                    Route::get('list', 'list');
                    Route::post('apply/{id}', 'applyLoan');
                    Route::post('confirm/{id}', 'loanConfirm');
                    Route::get('instalment/logs/{loan_number}', 'installments');
                });

                //=======================start user beneficiary route======================//
                Route::controller('BeneficiaryController')->prefix('beneficiary')->group(function () {
                    Route::get('own', 'ownBeneficiary')->middleware('checkModule:own_bank');
                    Route::post('own', 'addOwnBeneficiary')->middleware('checkModule:own_bank');

                    Route::get('other', 'otherBeneficiary')->middleware('checkModule:other_bank');
                    Route::post('other', 'addOtherBeneficiary')->middleware('checkModule:other_bank');
                    Route::get('/bank-data', 'bankFormData');
                    Route::get('/details/{id}', 'details');

                    Route::get('account-number/check', 'checkAccountNumber');
                });

                //===================start the user transfer route ====================//
                Route::controller('OwnTransferController')->prefix('own/transfer')->name('own.transfer.')->group(function () {
                    Route::middleware('checkModule:own_bank')->group(function () {
                        Route::post('request/{id}', 'transferRequest');
                        Route::get('confirm/{id}', 'confirm')->name('confirm');
                    });
                });
                Route::controller('OtherTransferController')->prefix('other/transfer')->name('other.transfer.')->group(function () {
                    Route::middleware('checkModule:other_bank')->group(function () {
                        Route::post('request/{id}', 'transferRequest');
                        Route::get('confirm/{id}', 'confirm')->name('confirm');
                    });
                });

                Route::controller('WireTransferController')->middleware('checkModule:wire_transfer')->prefix('wire-transfer')->group(function () {
                    Route::get('', 'wireTransfer');
                    Route::post('request', 'transferRequest');
                    Route::get('confirm/{id}', 'confirm')->name('transfer.wire.confirm');
                    Route::get('details/{id}', 'details');
                });
            });
        });
    });

    Route::get('unauthenticated', 'UserController@unauthenticated');
    Route::get('language/{code}', 'UserController@language');
    Route::get('policy-pages', 'UserController@policyPages');
    Route::get('policy-detail', 'UserController@policyDetail');
    Route::get('faq', 'UserController@faq');
});
