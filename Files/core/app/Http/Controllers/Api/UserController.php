<?php

namespace App\Http\Controllers\Api;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\BalanceTransfer;
use App\Models\Deposit;
use App\Models\DeviceToken;
use App\Models\Dps;
use App\Models\Fdr;
use App\Models\Form;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\Loan;
use App\Models\ReferralSetting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\Withdrawal;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller {

    public function dashboard() {
        $user = auth()->user();

        $widget['total_deposit']  = Deposit::where('user_id', $user->id)->where('status', 1)->sum('amount');
        $widget['total_fdr']      = Fdr::where('user_id', $user->id)->count();
        $widget['total_withdraw'] = Withdrawal::approved()->where('user_id', $user->id)->sum('amount');
        $widget['total_loan']     = Loan::approved()->where('user_id', $user->id)->count();
        $widget['total_dps']      = Dps::where('user_id', $user->id)->count();
        $widget['total_trx']      = Transaction::where('user_id', $user->id)->count();

        $credits = Transaction::where('user_id', $user->id)->where('trx_type', '+')->apiQuery();
        $debits  = Transaction::where('user_id', $user->id)->where('trx_type', '-')->apiQuery();

        $filePath = getFilePath('userProfile');

        $notify[] = 'User dashboard data';
        return response()->json([
            'remark'  => 'dashboard',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'user'           => $user,
                'dashboard_data' => $widget,
                'latest_credits' => $credits,
                'latest_debits'  => $debits,
                'filePath'       => $filePath,
            ],
        ]);
    }

    public function userInfo() {
        $notify[]       = 'User information';
        $user           = auth()->user();
        $general        = gs();
        $user->balance  = $general->cur_sym . showAmount($user->balance);
        $user->fullname = $user->fullname;

        return response()->json([
            'remark'  => 'user_info',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'user' => $user,
            ],
        ]);
    }

    public function userDataSubmit(Request $request) {
        $user = auth()->user();
        if ($user->profile_complete == 1) {
            $notify[] = 'You\'ve already completed your profile';
            return response()->json([
                'remark'  => 'already_completed',
                'status'  => 'error',
                'message' => ['error' => $notify],
            ]);
        }
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname'  => 'required',
            'address'   => 'nullable|string',
            'state'     => 'nullable|string',
            'zip'       => 'nullable|string',
            'city'      => 'nullable|string',
            'image'     => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'remark'  => 'validation_error',
                'status'  => 'error',
                'message' => ['error' => $validator->errors()->all()],
            ]);
        }

        if ($request->hasFile('image')) {
            try {
                $old         = $user->image;
                $user->image = fileUploader($request->image, getFilePath('userProfile'), getFileSize('userProfile'), $old);
            } catch (\Exception$exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;
        $user->address   = [
            'country' => @$user->address->country,
            'address' => $request->address,
            'state'   => $request->state,
            'zip'     => $request->zip,
            'city'    => $request->city,
        ];

        $user->profile_complete = Status::YES;
        $user->save();

        $notify[] = 'Profile completed successfully';
        return response()->json([
            'remark'  => 'profile_completed',
            'status'  => 'success',
            'message' => ['success' => $notify],
        ]);
    }

    public function kycForm() {
        $user = auth()->user();
        if ($user->kv == 2) {
            $notify[] = 'Your KYC is under review';
            return response()->json([
                'remark'  => 'under_review',
                'status'  => 'error',
                'message' => ['error' => $notify],
            ]);
        }
        if ($user->kv == 1) {
            $notify[] = 'You are already KYC verified';
            return response()->json([
                'remark'  => 'already_verified',
                'status'  => 'error',
                'message' => ['error' => $notify],
            ]);
        }

        $form     = Form::where('act', 'kyc')->first();
        $notify[] = 'KYC field is below';
        return response()->json([
            'remark'  => 'kyc_form',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'form' => @$form->form_data,
            ],
        ]);
    }

    public function kycSubmit(Request $request) {
        $form           = Form::where('act', 'kyc')->first();
        $formData       = $form->form_data;
        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);

        $validator = Validator::make($request->all(), $validationRule);

        if ($validator->fails()) {
            return response()->json([
                'remark'  => 'validation_error',
                'status'  => 'error',
                'message' => ['error' => $validator->errors()->all()],
            ]);
        }

        $userData       = $formProcessor->processFormData($request, $formData);
        $user           = auth()->user();
        $user->kyc_data = $userData;
        $user->kv       = 2;
        $user->save();

        $notify[] = 'KYC data submitted successfully';
        return response()->json([
            'remark'  => 'kyc_submitted',
            'status'  => 'success',
            'message' => ['success' => $notify],
        ]);
    }

    public function kycData() {
        $user     = auth()->user();
        $notify[] = 'User KYC Data';
        return response()->json([
            'remark'  => 'kyc_data',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'user'    => $user,
        ]);
    }

    public function depositHistory(Request $request) {
        $deposits = auth()->user()->deposits()->searchable(['trx'])->with(['gateway'])->apiQuery();
        $path     = getFilePath('verify');
        $notify[] = 'Deposit History';
        return response()->json([
            'remark'  => 'deposits_history',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'deposits' => $deposits,
                'path'     => $path,
            ],
        ]);
    }

    public function transactions(Request $request) {
        $remarks      = Transaction::distinct('remark')->get('remark');
        $transactions = Transaction::where('user_id', auth()->id())->searchable(['trx'])->filter(['trx_type', 'remark'])->apiQuery();
        $notify[]     = 'Transactions data';
        return response()->json([
            'remark'  => 'transactions',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'transactions' => $transactions,
                'remarks'      => $remarks,
            ],
        ]);
    }

    public function submitProfile(Request $request) {

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname'  => 'required|string',
            'image'     => ['nullable', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ], [
            'firstname.required' => 'First name field is required',
            'lastname.required'  => 'Last name field is required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'remark'  => 'validation_error',
                'status'  => 'error',
                'message' => ['error' => $validator->errors()->all()],
            ]);
        }

        $user = auth()->user();

        if ($request->hasFile('image')) {
            try {
                $old         = $user->image;
                $user->image = fileUploader($request->image, getFilePath('userProfile'), getFileSize('userProfile'), $old);
            } catch (\Exception$exp) {
                return response()->json([
                    'remark'  => 'exception_error',
                    'status'  => 'error',
                    'message' => ['error' => ['Couldn\'t upload your image']],
                ]);
            }
        }

        $user->firstname = $request->firstname;
        $user->lastname  = $request->lastname;

        $user->address = [
            'country' => @$user->address->country,
            'address' => $request->address,
            'state'   => $request->state,
            'zip'     => $request->zip,
            'city'    => $request->city,
        ];

        $user->save();

        $notify[] = 'Profile updated successfully';
        return response()->json([
            'remark'  => 'profile_updated',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'user' => $user,
            ],
        ]);
    }

    public function submitPassword(Request $request) {
        $passwordValidation = Password::min(6);
        $general            = gs();

        if ($general->secure_password) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', $passwordValidation],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'remark'  => 'validation_error',
                'status'  => 'error',
                'message' => ['error' => $validator->errors()->all()],
            ]);
        }

        $user = auth()->user();
        if (Hash::check($request->current_password, $user->password)) {
            $password       = Hash::make($request->password);
            $user->password = $password;
            $user->save();

            $notify[] = 'Password changed successfully';
            return response()->json([
                'remark'  => 'password_changed',
                'status'  => 'success',
                'message' => ['success' => $notify],
            ]);
        } else {
            $notify[] = 'The password doesn\'t match!';
            return response()->json([
                'remark'  => 'validation_error',
                'status'  => 'error',
                'message' => ['error' => $notify],
            ]);
        }
    }

    public function unauthenticated() {
        $notify[] = 'Unauthenticated';
        return response()->json([
            'remark'  => 'unauthenticated_error',
            'status'  => 'error',
            'message' => ['error' => $notify],
        ]);
    }

    public function generalSetting() {
        $general        = GeneralSetting::first();
        $transferCharge = $general->transferCharge();
        $notify[]       = 'General Setting';
        return response()->json([
            'remark'  => 'general_setting',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'general'         => $general,
                'transfer_charge' => $transferCharge,
            ],
        ]);
    }

    public function referredUsers() {
        $maxLevel  = ReferralSetting::max('level');
        $relations = [];
        for ($label = 1; $label <= $maxLevel; $label++) {
            $relations[$label] = (@$relations[$label - 1] ? $relations[$label - 1] . '.allReferees' : 'allReferees');
        }
        $user      = auth()->user()->load($relations);
        $referrals = getReferees($user, $maxLevel);
        $notify[]  = 'My Referrals';
        return response()->json([
            'remark'  => 'referred_users',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'referrals' => $referrals,
            ],
        ]);
    }

    public function policyPages() {
        $policyPages = getContent('policy_pages.element', false, null, true);
        $notify[]    = 'Policy Pages';
        return response()->json([
            'remark'  => 'policy_pages',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'policy_pages' => $policyPages,
            ],
        ]);
    }

    public function policyDetail(Request $request) {

        $policyDetail = Frontend::where('id', $request->id)->first();
        if (!$policyDetail) {
            $notify[] = 'Policy detail not found';
            return response()->json([
                'remark'  => 'page_not_found',
                'status'  => 'error',
                'message' => ['error' => $notify],
            ]);
        }

        $notify[] = 'Policy detail';
        return response()->json([
            'remark'  => 'policy_detail',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'policy_detail' => $policyDetail,
            ],
        ]);
    }

    public function referralLink() {

        $referralLink = route('home') . '?reference=' . auth()->user()->username;
        $notify[]     = 'User referral link';
        return response()->json([
            'remark'  => 'referral_link',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'referral_link' => $referralLink,
            ],
        ]);
    }
    public function transferHistory() {
        $transfers = BalanceTransfer::where('user_id', auth()->id())->with('beneficiary', 'beneficiary.beneficiaryOf')->apiQuery();
        $notify[]  = 'User transfer history';
        $path      = getFilePath('verify');
        return response()->json([
            'remark'  => 'transfer_history',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'transfers' => $transfers,
                'path'      => $path,
            ],
        ]);
    }

    public function language($code) {
        $language = Language::where('code', $code)->first();
        if (!$language) {
            $code = 'en';
        }
        $languageData = json_decode(file_get_contents(resource_path('lang/' . $code . '.json')));
        $languages    = Language::get();
        $notify[]     = 'Language Data';
        return response()->json([
            'remark'  => 'language_data',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'language_data' => $languageData,
                'languages'     => $languages,
            ],
        ]);
    }

    public function faq() {
        $faqs       = Frontend::where('data_keys', 'faq.element')->select('data_values')->get();
        $faqContent = Frontend::where('data_keys', 'faq.content')->select('data_values')->first();
        if (!$faqContent) {
            $notify[] = 'Faq not found';
            return response()->json([
                'remark'  => 'faq_error',
                'status'  => 'error',
                'message' => ['error' => $notify],
            ]);
        }
        return response()->json([
            'remark' => 'faq_data',
            'status' => 'success',
            'data'   => [
                'faqs'       => $faqs,
                'faqContent' => $faqContent,
            ],
        ]);
    }

    public function getDeviceToken(Request $request) {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'remark'  => 'validation_error',
                'status'  => 'error',
                'message' => ['error' => $validator->errors()->all()],
            ]);
        }

        $deviceToken = DeviceToken::where('token', $request->token)->first();
        if ($deviceToken) {
            $notify[] = 'Already exists';
            return response()->json([
                'remark'  => 'get_device_token',
                'status'  => 'success',
                'message' => ['success' => $notify],
            ]);
        }

        $deviceToken          = new DeviceToken();
        $deviceToken->user_id = auth()->user()->id;
        $deviceToken->token   = $request->token;
        $deviceToken->is_app  = 1;
        $deviceToken->save();

        $notify[] = 'Token save successfully';
        return response()->json([
            'remark'  => 'get_device_token',
            'status'  => 'success',
            'message' => ['success' => $notify],
        ]);
    }

    public function notificationHistory() {
        $notifications = UserNotification::where('user_id', auth()->id())->apiQuery();
        $notify[]      = 'User Notification';
        return response()->json([
            'remark'  => 'user_notifications',
            'status'  => 'success',
            'message' => ['success' => $notify],
            'data'    => [
                'notifications' => $notifications,
            ],
        ]);
    }

    public function notificationDetail($id) {
        $notification = UserNotification::where('user_id', auth()->id())->where('id', $id)->first();
        if (!$notification) {
            $notify[] = 'Notification not found';
            return response()->json([
                'remark'  => 'validation_error',
                'status'  => 'error',
                'message' => ['error' => $notify],
            ]);
        }
        $screens = [
            'TRX_HISTORY'      => ['BAL_ADD', 'BAL_SUB', 'REFERRAL_COMMISSION', 'BALANCE_TRANSFER', 'BALANCE_RECEIVE'],
            'TRANSFER'         => ['OTHER_BANK_TRANSFER_COMPLETE', 'WIRE_TRANSFER_COMPLETED', 'OWN_BANK_TRANSFER_MONEY_SEND', 'OWN_BANK_TRANSFER_MONEY_RECEIVE', 'OTHER_BANK_TRANSFER_REQUEST_SEND'],
            'DEPOSIT_HISTORY'  => ['DEPOSIT_COMPLETE', 'DEPOSIT_APPROVE', 'DEPOSIT_REJECT', 'DEPOSIT_REQUEST'],
            'WITHDRAW_HISTORY' => ['WITHDRAW_APPROVE'],
            'LOAN_LIST'        => ['LOAN_APPROVE', 'LOAN_REJECT', 'LOAN_PAID', 'LOAN_INSTALLMENT_DUE'],
            'DPS_LIST'         => ['DPS_OPENED', 'DPS_MATURED', 'DPS_CLOSED', 'DPS_INSTALLMENT_DUE'],
            'FDR_LIST'         => ['FDR_OPENED', 'FDR_CLOSED'],
            'HOME'             => ['KYC_REJECT', 'KYC_APPROVE'],
        ];

        foreach ($screens as $screen => $array) {
            if (in_array($notification->remark, $array)) {
                $notification->view = 1;
                $notification->save();
                return response()->json([
                    'remark' => 'notification_detail',
                    'status' => 'success',
                    'data'   => ['remark' => $screen, 'view' => $notification->view],
                ]);
            }
        }
        $notify[] = 'Notification not found';
        return response()->json([
            'remark'  => 'validation_error',
            'status'  => 'error',
            'message' => ['error' => $notify],
        ]);
    }
}
