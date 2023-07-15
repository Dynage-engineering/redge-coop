<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Lib\GoogleAuthenticator;
use App\Models\BalanceTransfer;
use App\Models\Deposit;
use App\Models\Dps;
use App\Models\Fdr;
use App\Models\Form;
use App\Models\Loan;
use App\Models\ReferralSetting;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdrawal;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;

class UserController extends Controller {

    public function home() {
        $pageTitle = 'Dashboard';
        $user      = auth()->user();

        $widget['total_deposit']  = Deposit::successful()->where('user_id', $user->id)->sum('amount');
        $widget['total_fdr']      = Fdr::where('user_id', $user->id)->count();
        $widget['total_withdraw'] = Withdrawal::approved()->where('user_id', $user->id)->sum('amount');
        $widget['total_loan']     = Loan::approved()->where('user_id', $user->id)->count();
        $widget['total_dps']      = Dps::where('user_id', $user->id)->count();
        $widget['total_trx']      = Transaction::where('user_id', $user->id)->count();

        $credits = Transaction::where('user_id', $user->id)->where('trx_type', '+')->latest()->limit(5)->get();
        $debits  = Transaction::where('user_id', $user->id)->where('trx_type', '-')->latest()->limit(5)->get();

        return view($this->activeTemplate . 'user.dashboard', compact('pageTitle', 'user', 'credits', 'debits', 'widget'));
    }

    public function depositHistory(Request $request) {
        $pageTitle = 'Deposit History';
        $deposits  = auth()->user()->deposits()->searchable(['trx'])->with(['gateway', 'branch'])->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.deposit_history', compact('pageTitle', 'deposits'));
    }

    public function show2faForm() {
        $general   = gs();
        $ga        = new GoogleAuthenticator();
        $user      = auth()->user();
        $secret    = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($user->username . '@' . $general->site_name, $secret);
        $pageTitle = '2FA Setting';
        return view($this->activeTemplate . 'user.twofactor', compact('pageTitle', 'secret', 'qrCodeUrl'));
    }

    public function create2fa(Request $request) {
        $user = auth()->user();

        $this->validate($request, [
            'key'  => 'required',
            'code' => 'required',
        ]);
        $response = verifyG2fa($user, $request->code, $request->key);

        if ($response) {
            $user->tsc = $request->key;
            $user->ts  = Status::ENABLE;
            $user->save();
            $notify[] = ['success', 'Google authenticator activated successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'Wrong verification code'];
            return back()->withNotify($notify);
        }
    }

    public function disable2fa(Request $request) {
        $this->validate($request, [
            'code' => 'required',
        ]);

        $user     = auth()->user();
        $response = verifyG2fa($user, $request->code);
        if ($response) {
            $user->tsc = null;
            $user->ts  = Status::DISABLE;
            $user->save();
            $notify[] = ['success', 'Two factor authenticator disabled successfully'];
        } else {
            $notify[] = ['error', 'Wrong verification code'];
        }
        return back()->withNotify($notify);
    }

    public function transactions(Request $request) {
        $pageTitle    = 'Transactions';
        $remarks      = Transaction::distinct('remark')->whereNotNull('remark')->orderBy('remark')->get('remark');
        $transactions = auth()->user()->transactions();

        if (request()->search) {
            $transactions = $transactions->where('trx', request()->search);
        }
        if (request()->trx_type) {
            $transactions = $transactions->where('trx_type', request()->trx_type);
        }
        if (request()->remark) {
            $transactions = $transactions->where('remark', request()->remark);
        }
        $transactions = $transactions->orderBy('id', 'desc')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.transactions', compact('pageTitle', 'transactions', 'remarks'));
    }

    public function kycForm() {
        if (auth()->user()->kv == Status::KYC_PENDING) {
            $notify[] = ['error', 'Your KYC is under review'];
            return to_route('user.home')->withNotify($notify);
        }
        if (auth()->user()->kv == Status::KYC_VERIFIED) {
            $notify[] = ['error', 'You are already KYC verified'];
            return to_route('user.home')->withNotify($notify);
        }
        $pageTitle = 'KYC Form';
        $form      = Form::where('act', 'kyc')->first();
        return view($this->activeTemplate . 'user.kyc.form', compact('pageTitle', 'form'));
    }

    public function kycData() {
        $user      = auth()->user();
        $pageTitle = 'KYC Data';
        return view($this->activeTemplate . 'user.kyc.info', compact('pageTitle', 'user'));
    }

    public function kycSubmit(Request $request) {
        $form           = Form::where('act', 'kyc')->first();
        $formData       = $form->form_data;
        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $userData       = $formProcessor->processFormData($request, $formData);
        $user           = auth()->user();
        $user->kyc_data = $userData;
        $user->kv       = Status::KYC_PENDING;
        $user->save();

        $notify[] = ['success', 'KYC data submitted successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function attachmentDownload($fileHash) {
        $filePath  = decrypt($fileHash);
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        $general   = gs();
        $title     = slug($general->site_name) . '- attachments.' . $extension;
        $mimetype  = mime_content_type($filePath);
        header('Content-Disposition: attachment; filename="' . $title);
        header("Content-Type: " . $mimetype);
        return readfile($filePath);
    }

    public function userData() {
        $user = auth()->user();
        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }
        $pageTitle = 'User Data';
        return view($this->activeTemplate . 'user.user_data', compact('pageTitle', 'user'));
    }

    public function userDataSubmit(Request $request) {
        $user = auth()->user();

        if ($user->profile_complete == Status::YES) {
            return to_route('user.home');
        }

        $request->validate([
            'firstname' => 'required',
            'lastname'  => 'required',
            'address'   => 'nullable|string',
            'state'     => 'nullable|string',
            'zip'       => 'nullable|string',
            'city'      => 'nullable|string',
            'image'     => ['required', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

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

        $notify[] = ['success', 'Registration process completed successfully'];
        return to_route('user.home')->withNotify($notify);
    }

    public function downloadAttachment($fileHash) {
        return downloadAttachment($fileHash);
    }

    public function referredUsers() {
        $pageTitle = "My referred Users";
        $user      = auth()->user();
        $referees  = User::where('id', $user->id)->with('allReferees')->paginate(getPaginate());
        $maxLevel  = ReferralSetting::max('level');
        return view($this->activeTemplate . 'user.referral.index', compact('pageTitle', 'referees', 'user', 'maxLevel'));
    }

    public function transferHistory() {
        $pageTitle = 'Transfer History';
        $transfers = BalanceTransfer::where('user_id', auth()->id())->with('beneficiary', 'beneficiary.beneficiaryOf')->orderBy('id', 'DESC')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.transfer.history', compact('pageTitle', 'transfers'));
    }
}
