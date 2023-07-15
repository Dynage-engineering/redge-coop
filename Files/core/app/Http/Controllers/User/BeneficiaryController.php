<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\Beneficiary;
use App\Models\OtherBank;
use App\Models\User;
use Illuminate\Http\Request;

class BeneficiaryController extends Controller {

    public function ownBankBeneficiaries() {
        $pageTitle     = 'Beneficiaries of ' . gs()->site_name;
        $beneficiaries = Beneficiary::ownBank()->where('user_id', auth()->id())->paginate(getPaginate());
        return view($this->activeTemplate . 'user.transfer.beneficiary.own', compact('pageTitle', 'beneficiaries'));
    }

    public function otherBankBeneficiaries() {
        $pageTitle     = 'Other Bank Beneficiaries';
        $otherBanks    = OtherBank::active()->get();
        $beneficiaries = Beneficiary::otherBank()->where('user_id', auth()->id())->with('beneficiaryOf')->paginate(getPaginate());
        return view($this->activeTemplate . 'user.transfer.beneficiary.other', compact('pageTitle', 'beneficiaries', 'otherBanks'));
    }

    public function addOwnBeneficiary(Request $request) {

        $request->validate([
            'account_number' => 'required|string',
            'account_name'   => 'required|string',
            'short_name'     => 'required|string',
        ]);

        $beneficiaryUser = User::where('account_number', $request->account_number)->where('username', $request->account_name)->first();

        if (!$beneficiaryUser) {
            $notify[] = ['error', 'Beneficiary account doesn\'t exists'];
            return back()->withNotify($notify)->withInput();
        }

        $beneficiaryExist = Beneficiary::where('user_id', auth()->id())->where('beneficiary_type', User::class)->where('beneficiary_id', $beneficiaryUser->id)->exists();

        if ($beneficiaryExist) {
            $notify[] = ['error', 'This beneficiary already added'];
            return back()->withNotify($notify);
        }

        $beneficiary                 = new Beneficiary();
        $beneficiary->user_id        = auth()->id();
        $beneficiary->account_number = $request->account_number;
        $beneficiary->account_name   = $request->account_name;
        $beneficiary->short_name     = $request->short_name;

        $beneficiaryUser->beneficiaryTypes()->save($beneficiary);

        $notify[] = ['success', 'Beneficiary added successfully'];
        return back()->withNotify($notify);
    }

    public function addOtherBeneficiary(Request $request) {

        $request->validate([
            'bank'       => 'required|integer',
            'short_name' => 'required',
        ]);

        $bank           = OtherBank::active()->findOrFail($request->bank);
        $formData       = $bank->form->form_data;
        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);

        $request->validate($validationRule);
        $userData = $formProcessor->processFormData($request, $formData);

        $beneficiary                 = new Beneficiary();
        $beneficiary->user_id        = auth()->id();
        $beneficiary->account_number = $request->account_number;
        $beneficiary->account_name   = $request->account_name;
        $beneficiary->short_name     = $request->short_name;
        $beneficiary->details        = $userData;

        $bank->beneficiaryTypes()->save($beneficiary);

        $notify[] = ['success', 'Beneficiary added successfully'];
        return back()->withNotify($notify);
    }

    public function details($id) {
        $beneficiary = Beneficiary::where('user_id', auth()->id())->where('id', $id)->first();

        if (!$beneficiary) {
            return response()->json([
                'success' => false,
                'message' => "Beneficiary not found",
            ]);
        }
        $data = @$beneficiary->details;

        $html = view('components.view-form-data', compact('data'))->render();

        return response()->json([
            'success' => true,
            'html'    => $html,
        ]);
    }

    public function otherBankForm($id) {
        $bank = OtherBank::active()->where('id', $id)->first();

        if (!$bank) {
            return response()->json([
                'success' => false,
                'message' => "Bank not found",
            ]);
        }

        $formData = $bank->form->form_data;
        $html     = view('components.viser-form', compact('formData'))->render();

        return response()->json([
            'success' => true,
            'html'    => $html,
        ]);
    }

    public function checkAccountNumber(Request $request) {
        $user = User::where('account_number', $request->account_number)->orWhere('username', $request->account_name)->first();

        if (!$user || @$user->id == auth()->id()) {
            return response()->json(['error' => true, 'message' => 'No such account found']);
        }

        $data = [
            'account_number' => $user->account_number,
            'account_name'   => $user->username,
        ];

        return response()->json(['error' => false, 'data' => $data]);
    }
}
