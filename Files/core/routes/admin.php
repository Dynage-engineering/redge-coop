<?php

use Illuminate\Support\Facades\Route;

Route::namespace ('Auth')->group(function () {
    Route::controller('LoginController')->group(function () {
        Route::get('/', 'showLoginForm')->name('login');
        Route::post('/', 'login')->name('login');
        Route::get('logout', 'logout')->name('logout');
    });
    // Admin Password Reset
    Route::controller('ForgotPasswordController')->prefix('password')->name('password.')->group(function () {
        Route::get('reset', 'showLinkRequestForm')->name('reset');
        Route::post('reset', 'sendResetCodeEmail');
        Route::get('code-verify', 'codeVerify')->name('code.verify');
        Route::post('verify-code', 'verifyCode')->name('verify.code');
    });

    Route::controller('ResetPasswordController')->group(function () {
        Route::get('password/reset/{token}', 'showResetForm')->name('password.reset.form');
        Route::post('password/reset/change', 'reset')->name('password.change');
    });
});

Route::middleware('admin')->group(function () {
    Route::controller('AdminController')->group(function () {
        Route::get('dashboard', 'dashboard')->name('dashboard');
        Route::get('profile', 'profile')->name('profile');
        Route::post('profile', 'profileUpdate')->name('profile.update');
        Route::get('password', 'password')->name('password');
        Route::post('password', 'passwordUpdate')->name('password.update');

        //Notification
        Route::get('notifications', 'notifications')->name('notifications');
        Route::get('notification/read/{id}', 'notificationRead')->name('notification.read');
        Route::get('notifications/read-all', 'readAll')->name('notifications.readAll');

        //Report Bugs
        Route::get('request-report', 'requestReport')->name('request.report');
        Route::post('request-report', 'reportSubmit');

        Route::get('beneficiary/details/{id}', 'beneficiaryDetails')->name('beneficiary.details');
        Route::get('download-attachments/{file_hash}', 'downloadAttachment')->name('download.attachment');
    });

    // Users Manager
    Route::controller('ManageUsersController')->name('users.')->prefix('users')->group(function () {
        Route::get('/', 'allUsers')->name('all');
        Route::get('active', 'activeUsers')->name('active');
        Route::get('banned', 'bannedUsers')->name('banned');
        Route::get('email-verified', 'emailVerifiedUsers')->name('email.verified');
        Route::get('email-unverified', 'emailUnverifiedUsers')->name('email.unverified');
        Route::get('mobile-unverified', 'mobileUnverifiedUsers')->name('mobile.unverified');
        Route::get('kyc-unverified', 'kycUnverifiedUsers')->name('kyc.unverified');
        Route::get('kyc-pending', 'kycPendingUsers')->name('kyc.pending');
        Route::get('mobile-verified', 'mobileVerifiedUsers')->name('mobile.verified');
        Route::get('with-balance', 'usersWithBalance')->name('with.balance');
        Route::get('owes', 'owesUsers')->name('owes');
        Route::get('owes/dps/{userId}', 'owesDps')->name('owes.dps');
        Route::get('owes/loan/{userId}', 'owesLoan')->name('owes.loan');

        Route::get('detail/{id}', 'detail')->name('detail');
        Route::get('kyc-data/{id}', 'kycDetails')->name('kyc.details');
        Route::post('kyc-approve/{id}', 'kycApprove')->name('kyc.approve');
        Route::post('kyc-reject/{id}', 'kycReject')->name('kyc.reject');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('add-sub-balance/{id}', 'addSubBalance')->name('add.sub.balance');
        Route::get('send-notification/{id}', 'showNotificationSingleForm')->name('notification.single');
        Route::post('send-notification/{id}', 'sendNotificationSingle')->name('notification.single');
        Route::get('login/{id}', 'login')->name('login');
        Route::post('status/{id}', 'status')->name('status');

        Route::get('send-notification', 'showNotificationAllForm')->name('notification.all');
        Route::post('send-notification', 'sendNotificationAll')->name('notification.all.send');
        Route::get('notification-log/{id}', 'notificationLog')->name('notification.log');
        Route::get('user/beneficiaries/{id}', 'ManageUsersController@beneficiaries')->name('beneficiaries');
    });

    // Subscriber
    Route::controller('SubscriberController')->prefix('subscriber')->name('subscriber.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('send-email', 'sendEmailForm')->name('send.email');
        Route::post('remove/{id}', 'remove')->name('remove');
        Route::post('send-email', 'sendEmail')->name('send.email');
    });

    // Deposit Gateway
    Route::name('gateway.')->prefix('gateway')->group(function () {

        // Automatic Gateway
        Route::controller('AutomaticGatewayController')->prefix('automatic')->name('automatic.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('edit/{alias}', 'edit')->name('edit');
            Route::post('update/{code}', 'update')->name('update');
            Route::post('remove/{id}', 'remove')->name('remove');
            Route::post('status/{id}', 'status')->name('status');
        });

        // Manual Methods
        Route::controller('ManualGatewayController')->prefix('manual')->name('manual.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('new', 'create')->name('create');
            Route::post('new', 'store')->name('store');
            Route::get('edit/{alias}', 'edit')->name('edit');
            Route::post('update/{id}', 'update')->name('update');
            Route::post('status/{id}', 'status')->name('status');
        });
    });

    // DEPOSIT SYSTEM
    Route::controller('DepositController')->prefix('deposit')->name('deposit.')->group(function () {
        Route::get('/', 'deposit')->name('list');
        Route::get('pending', 'pending')->name('pending');
        Route::get('rejected', 'rejected')->name('rejected');
        Route::get('approved', 'approved')->name('approved');
        Route::get('successful', 'successful')->name('successful');
        Route::get('initiated', 'initiated')->name('initiated');
        Route::get('details/{id}', 'details')->name('details');
        Route::post('reject', 'reject')->name('reject');
        Route::post('approve/{id}', 'approve')->name('approve');
    });

    // WITHDRAW SYSTEM
    Route::name('withdraw.')->prefix('withdraw')->group(function () {

        Route::controller('WithdrawalController')->group(function () {
            Route::get('pending', 'pending')->name('pending');
            Route::get('approved', 'approved')->name('approved');
            Route::get('rejected', 'rejected')->name('rejected');
            Route::get('log', 'log')->name('log');
            Route::get('details/{id}', 'details')->name('details');
            Route::post('approve', 'approve')->name('approve');
            Route::post('reject', 'reject')->name('reject');
        });

        // Withdraw Method
        Route::controller('WithdrawMethodController')->prefix('method')->name('method.')->group(function () {
            Route::get('/', 'methods')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('create', 'store')->name('store');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('edit/{id}', 'update')->name('update');
            Route::post('status/{id}', 'status')->name('status');
        });
    });

    // Report
    Route::controller('ReportController')->prefix('report')->name('report.')->group(function () {
        Route::get('transaction', 'transaction')->name('transaction');
        Route::get('login/history', 'loginHistory')->name('login.history');
        Route::get('login/ipHistory/{ip}', 'loginIpHistory')->name('login.ipHistory');
        Route::get('notification/history', 'notificationHistory')->name('notification.history');
        Route::get('email/detail/{id}', 'emailDetails')->name('email.details');
    });

    // Admin Support
    Route::controller('SupportTicketController')->prefix('ticket')->name('ticket.')->group(function () {
        Route::get('/', 'tickets')->name('index');
        Route::get('pending', 'pendingTicket')->name('pending');
        Route::get('closed', 'closedTicket')->name('closed');
        Route::get('answered', 'answeredTicket')->name('answered');
        Route::get('view/{id}', 'ticketReply')->name('view');
        Route::post('reply/{id}', 'replyTicket')->name('reply');
        Route::post('close/{id}', 'closeTicket')->name('close');
        Route::get('download/{ticket}', 'ticketDownload')->name('download');
        Route::post('delete/{id}', 'ticketDelete')->name('delete');
    });

    // Language Manager
    Route::controller('LanguageController')->prefix('language')->name('language.')->group(function () {
        Route::get('/', 'langManage')->name('manage');
        Route::post('/', 'langStore')->name('manage.store');
        Route::post('delete/{id}', 'langDelete')->name('manage.delete');
        Route::post('update/{id}', 'langUpdate')->name('manage.update');
        Route::get('edit/{id}', 'langEdit')->name('key');
        Route::post('import', 'langImport')->name('import.lang');
        Route::post('store/key/{id}', 'storeLanguageJson')->name('store.key');
        Route::post('delete/key/{id}', 'deleteLanguageJson')->name('delete.key');
        Route::post('update/key/{id}', 'updateLanguageJson')->name('update.key');
    });

    Route::controller('GeneralSettingController')->group(function () {
        // General Setting
        Route::get('general-setting', 'index')->name('setting.index');
        Route::post('general-setting', 'update')->name('setting.update');

        //configuration
        Route::get('setting/system-configuration', 'systemConfiguration')->name('setting.system.configuration');
        Route::post('setting/system-configuration', 'systemConfigurationSubmit');

        // Logo-Icon
        Route::get('setting/logo-icon', 'logoIcon')->name('setting.logo.icon');
        Route::post('setting/logo-icon', 'logoIconUpdate')->name('setting.logo.icon');

        //Custom CSS
        Route::get('custom-css', 'customCss')->name('setting.custom.css');
        Route::post('custom-css', 'customCssSubmit');

        //Cookie
        Route::get('cookie', 'cookie')->name('setting.cookie');
        Route::post('cookie', 'cookieSubmit');

        //maintenance_mode
        Route::get('maintenance-mode', 'maintenanceMode')->name('maintenance.mode');
        Route::post('maintenance-mode', 'maintenanceModeSubmit');
    });

    //KYC setting
    Route::controller('KycController')->group(function () {
        Route::get('kyc-setting', 'setting')->name('kyc.setting');
        Route::post('kyc-setting', 'settingUpdate');
    });

    Route::controller('ReferralSettingController')->group(function () {
        Route::get('referral-setting', 'index')->name('referral.setting');
        Route::post('referral-setting', 'save');
        Route::post('referral-count', 'commissionCount')->name('referral.setting.count');
    });

    //Notification Setting
    Route::name('setting.notification.')->controller('NotificationController')->prefix('notification')->group(function () {
        //Template Setting
        Route::get('global', 'global')->name('global');
        Route::post('global/update', 'globalUpdate')->name('global.update');
        Route::get('templates', 'templates')->name('templates');
        Route::get('template/edit/{id}', 'templateEdit')->name('template.edit');
        Route::post('template/update/{id}', 'templateUpdate')->name('template.update');

        //Email Setting
        Route::get('email/setting', 'emailSetting')->name('email');
        Route::post('email/setting', 'emailSettingUpdate');
        Route::post('email/test', 'emailTest')->name('email.test');

        //SMS Setting
        Route::get('sms/setting', 'smsSetting')->name('sms');
        Route::post('sms/setting', 'smsSettingUpdate');
        Route::post('sms/test', 'smsTest')->name('sms.test');

        route::get('push', 'push')->name('push');
        route::post('push/setting', 'pushSetting')->name('push.setting');
    });

    // Plugin
    Route::controller('ExtensionController')->prefix('extensions')->name('extensions.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('update/{id}', 'update')->name('update');
        Route::post('status/{id}', 'status')->name('status');
    });

    //System Information
    Route::controller('SystemController')->name('system.')->prefix('system')->group(function () {
        Route::get('info', 'systemInfo')->name('info');
        Route::get('server-info', 'systemServerInfo')->name('server.info');
        Route::get('optimize', 'optimize')->name('optimize');
        Route::get('optimize-clear', 'optimizeClear')->name('optimize.clear');
    });

    // SEO
    Route::get('seo', 'FrontendController@seoEdit')->name('seo');

    // Frontend
    Route::name('frontend.')->prefix('frontend')->group(function () {

        Route::controller('FrontendController')->group(function () {
            Route::get('templates', 'templates')->name('templates');
            Route::post('templates', 'templatesActive')->name('templates.active');
            Route::get('frontend-sections/{key}', 'frontendSections')->name('sections');
            Route::post('frontend-content/{key}', 'frontendContent')->name('sections.content');
            Route::get('frontend-element/{key}/{id?}', 'frontendElement')->name('sections.element');
            Route::post('remove/{id}', 'remove')->name('remove');
        });

        // Page Builder
        Route::controller('PageBuilderController')->group(function () {
            Route::get('manage-pages', 'managePages')->name('manage.pages');
            Route::post('manage-pages', 'managePagesSave')->name('manage.pages.save');
            Route::post('manage-pages/update', 'managePagesUpdate')->name('manage.pages.update');
            Route::post('manage-pages/delete/{id}', 'managePagesDelete')->name('manage.pages.delete');
            Route::get('manage-section/{id}', 'manageSection')->name('manage.section');
            Route::post('manage-section/{id}', 'manageSectionUpdate')->name('manage.section.update');
        });
    });

    Route::name('plans.')->prefix('plans')->group(function () {
        //============Loan Plan================//
        Route::name('loan.')->prefix('loan')->controller('LoanPlanController')->group(function () {
            Route::get('/index', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('store/{id?}', 'store')->name('save');
            Route::post('status/{id}', 'changeStatus')->name('status');
        });

        //============DPS Plan================//
        Route::name('dps.')->prefix('dps')->controller('DpsPlanController')->group(function () {
            Route::get('index', 'index')->name('index');
            Route::get('add-new', 'addNew')->name('add');
            Route::get('edit/{id}', 'edit')->name('edit');
            Route::post('store/{id?}', 'store')->name('save');
            Route::post('status/{id}', 'changeStatus')->name('status');
        });

        //============FDR Plan================//
        Route::name('fdr.')->prefix('fdr')->controller('FdrPlanController')->group(function () {
            Route::get('index', 'index')->name('index');
            Route::post('store/{id?}', 'store')->name('save');
            Route::post('status/{id}', 'changeStatus')->name('status');
        });
    });

    //============Loan================//
    Route::name('loan.')->prefix('loan')->controller('LoanController')->group(function () {
        Route::get('all', 'index')->name('index');
        Route::get('running', 'runningLoans')->name('running');
        Route::get('pending', 'pendingLoans')->name('pending');
        Route::get('rejected', 'rejectedLoans')->name('rejected');
        Route::get('paid', 'paidLoans')->name('paid');
        Route::get('due', 'dueInstallment')->name('due');
        Route::post('approve/{id}', 'approve')->name('approve');
        Route::post('reject/{id}', 'reject')->name('reject');
        Route::get('details/{id}', 'details')->name('details');
        Route::get('installments/{id}', 'installments')->name('installments');
    });

    //=============DPS================//
    Route::name('dps.')->prefix('dps')->controller('DpsController')->group(function () {
        Route::get('all', 'index')->name('index');
        Route::get('running', 'runningDps')->name('running');
        Route::get('matured', 'maturedDps')->name('matured');
        Route::get('closed', 'closedDps')->name('closed');
        Route::get('due', 'dueInstallment')->name('due');
        Route::get('installments/{id}', 'installments')->name('installments');
    });

    //=============FDR================//
    Route::name('fdr.')->prefix('fdr')->controller('FdrController')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('running', 'runningFdr')->name('running');
        Route::get('closed', 'closedFdr')->name('closed');
        Route::get('due', 'dueInstallment')->name('due');
        Route::post('due/pay/{id}', 'payDue')->name('due.pay');

        Route::get('installments/{id}', 'installments')->name('installments');
    });

    //=================Others Bank=========================//
    Route::name('bank.')->prefix('other-banks')->controller('OtherBankController')->group(function () {
        Route::get('create', 'create')->name('create');
        Route::post('store/{id?}', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::get('index', 'index')->name('index');
        Route::post('change/status/{id}', 'changeStatus')->name('change.status');
    });

    //=================Wire Transfer=========================//
    Route::name('wire.transfer.')->prefix('wire-transfer')->controller('WireTransferSettingController')->group(function () {
        Route::get('setting', 'setting')->name('setting');
        Route::post('setting', 'saveSetting');
        Route::get('form', 'form')->name('form');
        Route::post('form', 'saveForm');
    });

    //=============Transfer route=======================//
    Route::name('transfers.')->prefix('transfers')->controller('MoneyTransferController')->group(function () {
        Route::get('all', 'index')->name('index');
        Route::get('pending', 'pending')->name('pending');
        Route::get('rejected', 'rejected')->name('rejected');
        Route::get('own-bank', 'ownBank')->name('own');
        Route::get('other-bank', 'otherBank')->name('other');
        Route::get('wire-transfer', 'wireTransfer')->name('wire');
        Route::get('details/{id}', 'details')->name('details');
        Route::post('reject', 'reject')->name('reject');
        Route::post('complete/{id}', 'complete')->name('complete');
    });

    //============== Branch =======================//
    Route::name('branch.')->prefix('branch')->controller('BranchController')->group(function () {
        Route::get('all', 'index')->name('index');
        Route::get('new', 'addNew')->name('add');
        Route::get('details/{id}', 'details')->name('details');
        Route::post('save/{id?}', 'save')->name('save');
        Route::post('status/{id}', 'changeStatus')->name('status');
    });

    //============== Branch Staff =======================//
    Route::name('branch.staff.')->prefix('branch/staff')->controller('BranchStaffController')->group(function () {
        Route::get('index', 'index')->name('index');
        Route::get('new', 'addNew')->name('add');
        Route::get('details/{id}', 'details')->name('details');
        Route::post('save/{id?}', 'save')->name('save');
        Route::post('status/{id}', 'changeStatus')->name('status');
        Route::get('login/{id}', 'login')->name('login');
    });
});
