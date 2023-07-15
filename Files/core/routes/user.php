<?php

use Illuminate\Support\Facades\Route;

Route::namespace ('User\Auth')->name('user.')->group(function () {

    Route::controller('LoginController')->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
        Route::get('logout', 'logout')->name('logout');
    });

    Route::controller('RegisterController')->group(function () {
        Route::get('register', 'showRegistrationForm')->name('register');
        Route::post('register', 'register')->middleware('registration.status');
    });

    Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function () {
        Route::get('reset', 'showLinkRequestForm')->name('request');
        Route::post('email', 'sendResetCodeEmail')->name('email');
        Route::get('code-verify', 'codeVerify')->name('code.verify');
        Route::post('verify-code', 'verifyCode')->name('verify.code');
    });

    Route::controller('ResetPasswordController')->group(function () {
        Route::post('password/reset', 'reset')->name('password.update');
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    });
});

Route::middleware('auth')->name('user.')->group(function () {
    //authorization
    Route::namespace ('User')->controller('AuthorizationController')->group(function () {
        Route::get('authorization', 'authorizeForm')->name('authorization');
        Route::get('resend-verify/{type}', 'sendVerifyCode')->name('send.verify.code');
        Route::post('verify-email', 'emailVerification')->name('verify.email');
        Route::post('verify-mobile', 'mobileVerification')->name('verify.mobile');
        Route::post('verify-g2fa', 'g2faVerification')->name('go2fa.verify');
    });

    Route::middleware(['check.status'])->group(function () {

        Route::get('user-data', 'User\UserController@userData')->name('data');
        Route::post('user-data-submit', 'User\UserController@userDataSubmit')->name('data.submit');

        Route::middleware('registration.complete')->namespace('User')->group(function () {

            // Actions
            Route::get('verify/otp', 'OTPController@verifyOtp')->name('otp.verify');
            Route::post('check/otp/{id}', 'OTPController@submitOTP')->name('otp.submit');
            Route::post('resend/otp/{id}', 'OTPController@resendOtp')->name('otp.resend');

            Route::controller('UserController')->group(function () {

                Route::get('dashboard', 'home')->name('home');

                //2FA
                Route::get('twofactor', 'show2faForm')->name('twofactor');
                Route::post('twofactor/enable', 'create2fa')->name('twofactor.enable');
                Route::post('twofactor/disable', 'disable2fa')->name('twofactor.disable');

                //KYC
                Route::get('kyc-form', 'kycForm')->name('kyc.form');
                Route::get('kyc-data', 'kycData')->name('kyc.data');
                Route::post('kyc-submit', 'kycSubmit')->name('kyc.submit');

                //Report
                Route::any('deposit/history', 'depositHistory')->name('deposit.history');
                Route::get('transactions', 'transactions')->name('transactions.history');

                Route::get('attachment-download/{file}', 'attachmentDownload')->name('attachment.download');
            });

            //Profile setting
            Route::controller('ProfileController')->group(function () {
                Route::get('profile-setting', 'profile')->name('profile.setting');
                Route::post('profile-setting', 'submitProfile');
                Route::get('change-password', 'changePassword')->name('change.password');
                Route::post('change-password', 'submitPassword');
            });

            // Withdraw
            Route::middleware('checkModule:withdraw')->controller('WithdrawController')->prefix('withdraw')->name('withdraw')->group(function () {
                Route::middleware('kyc')->group(function () {
                    Route::get('/', 'withdrawMoney');
                    Route::post('/apply', 'apply')->name('.apply');
                    Route::get('/money', 'withdrawStore')->name('.money');
                    Route::get('preview', 'withdrawPreview')->name('.preview');
                    Route::post('preview', 'withdrawSubmit')->name('.submit');
                });
                Route::get('history', 'withdrawLog')->name('.history');
            });

            //================start user fdr route ================//
            Route::middleware('checkModule:fdr')->controller('FdrController')->name('fdr.')->prefix('fdr')->group(function () {
                Route::get('plans', 'plans')->name('plans');
                Route::post('apply/{id}', 'apply')->name('apply');
                Route::get('apply-preview', 'preview')->name('apply.preview');
                Route::post('apply-confirm/{id}', 'confirm')->name('apply.confirm');
                Route::get('list', 'list')->name('list');
                Route::post('close/{id}', 'close')->name('close');
                Route::get('instalment/logs/{fdr_number}', 'installments')->name('instalment.logs');
            });

            // ====================start user dps route ==================//
            Route::middleware('checkModule:dps')->controller('DpsController')->name('dps.')->prefix('dps')->group(function () {
                Route::get('plans', 'plans')->name('plans');
                Route::post('apply/{id}', 'apply')->name('apply');
                Route::get('apply-preview', 'preview')->name('apply.preview');
                Route::post('apply-confirm/{id}', 'confirm')->name('apply.confirm');
                Route::get('list', 'list')->name('list');
                Route::post('withdraw/{id}', 'withdraw')->name('withdraw');
                Route::get('instalment/logs/{dps_number}', 'installments')->name('instalment.logs');
            });

            // =================start user loan route ====================///
            Route::middleware('checkModule:loan')->controller('LoanController')->name('loan.')->prefix('loan')->group(function () {
                Route::get('plans', 'plans')->name('plans');
                Route::post('apply/{id}', 'applyLoan')->name('apply');
                Route::get('application-preview', 'loanPreview')->name('apply.form');
                Route::post('apply-confirm', 'confirm')->name('apply.confirm');
                Route::get('list', 'list')->name('list');
                Route::get('instalment/logs/{loan_number}', 'installments')->name('instalment.logs');
            });

            // ======================= Beneficiary route=====================
            Route::controller('BeneficiaryController')->name('beneficiary.')->prefix('beneficiary')->group(function () {

                Route::get('own-bank/beneficiaries', 'ownBankBeneficiaries')->name('own')->middleware(['checkModule:own_bank']);

                Route::get('other-bank/beneficiaries', 'otherBankBeneficiaries')->name('other')->middleware(['checkModule:other_bank']);

                Route::post('own-bank/add', 'addOwnBeneficiary')->name('own.add')->middleware('checkModule:own_bank');

                Route::post('other-bank/add', 'addOtherBeneficiary')->name('other.add')->middleware('checkModule:other_bank');
                Route::get('other-bank/form-data/{bankId}', 'otherBankForm')->name('other.bank.form.data');
                Route::get('account-number/check', 'BeneficiaryController@checkAccountNumber')->name('check.account');
                Route::get('details/{id}', 'details')->name('details');
            });

            // ===================Transfer ====================
            Route::name('transfer.')->prefix('transfer')->group(function () {

                Route::get('all', 'UserController@transferHistory')->name('history')->middleware(['checkModule:own_bank', 'checkModule:other_bank', 'checkModule:wire_transfer']);

                // ===================OWN Bank transfer ============
                Route::controller('OwnBankTransferController')->middleware('checkModule:own_bank')->prefix('own-bank')->name('own.bank.')->group(function () {
                    Route::get('', 'beneficiaries')->name('beneficiaries');
                    Route::post('request/{id}', 'transferRequest')->name('request');
                    Route::get('confirm', 'confirm')->name('confirm');
                });

                // ===================Other bank transfer ============
                Route::controller('OtherBankTransferController')->middleware('checkModule:other_bank')->prefix('other-bank')->name('other.bank.')->group(function () {
                    Route::get('', 'beneficiaries')->name('beneficiaries');
                    Route::post('request/{id}', 'transferRequest')->name('request');
                    Route::get('confirm', 'confirm')->name('confirm');
                });

                // =================== Wire Transfer ====================
                Route::controller('WireTransferController')->middleware('checkModule:wire_transfer')->prefix('wire-transfer')->name('wire.')->group(function () {
                    Route::get('', 'wireTransfer')->name('index');
                    Route::post('request', 'transferRequest')->name('request');
                    Route::get('confirm', 'confirm')->name('confirm');
                    Route::get('details/{id}', 'details')->name('details');
                });
            });
        });

        // Payment
        Route::middleware(['registration.complete', 'checkModule:deposit'])->prefix('deposit')->name('deposit.')->controller('Gateway\PaymentController')->group(function () {
            Route::any('/', 'deposit')->name('index');
            Route::post('insert', 'depositInsert')->name('insert');
            Route::get('confirm', 'depositConfirm')->name('confirm');
            Route::get('manual', 'manualDepositConfirm')->name('manual.confirm');
            Route::post('manual', 'manualDepositUpdate')->name('manual.update');
        });

        Route::middleware('checkModule:referral_system')->controller('User\UserController')->name('referral.')->group(function () {
            Route::get('referees', 'referredUsers')->name('users');
        });

        Route::get('transactions', 'User\UserController@transactions')->name('transaction.history');
        Route::get('download-attachments/{file_hash}', 'User\UserController@downloadAttachment')->name('download.attachment');
    });
});
