<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Lib\FormProcessor;
use App\Models\AdminNotification;
use App\Models\Loan;
use App\Models\LoanPlan;
use Illuminate\Http\Request;

class LoanController extends Controller {

    public function list() {
        $loans     = Loan::where('user_id', auth()->id())->with('nextInstallment')->with('plan')->orderBy('id', 'desc')->paginate(getPaginate());
        $pageTitle = 'My Loan List';
        return view($this->activeTemplate . 'user.loan.list', compact('pageTitle', 'loans'));
    }

    public function plans() {
        $pageTitle = 'Loan Plans';
        $plans     = LoanPlan::active()->latest()->get();
        return view($this->activeTemplate . 'user.loan.plans', compact('pageTitle', 'plans'));
    }

    public function applyLoan(Request $request, $id) {

        $plan = LoanPlan::active()->findOrFail($id);
        $request->validate(['amount' => "required|numeric|min:$plan->minimum_amount|max:$plan->maximum_amount"]);
        session()->put('loan', ['plan' => $plan, 'amount' => $request->amount]);
        return redirect()->route('user.loan.apply.form');
    }

    public function loanPreview() {
        $loan = session('loan');
        if (!$loan) {
            return redirect()->route('user.loan.plans');
        }
        $plan      = $loan['plan'];
        $amount    = $loan['amount'];
        $pageTitle = 'Apply For Loan';
        return view($this->activeTemplate . 'user.loan.form', compact('pageTitle', 'plan', 'amount'));
    }

    public function confirm(Request $request) {
        $loan = session('loan');
        if (!$loan) {
            return redirect()->route('user.loan.plans');
        }

        $plan   = $loan['plan'];
        $amount = $loan['amount'];
        $plan   = LoanPlan::active()->where('id', $plan->id)->firstOrFail();

        $formData       = $plan->form->form_data;
        $formProcessor  = new FormProcessor();
        $validationRule = $formProcessor->valueValidation($formData);
        $request->validate($validationRule);
        $applicationForm = $formProcessor->processFormData($request, $formData);

        $user            = auth()->user();
        $per_installment = $amount * $plan->per_installment / 100;

        $percentCharge = $plan->per_installment * $plan->percent_charge / 100;
        $charge        = $plan->fixed_charge + $percentCharge;

        $loan                         = new Loan();
        $loan->loan_number            = getTrx();
        $loan->user_id                = $user->id;
        $loan->plan_id                = $plan->id;
        $loan->amount                 = $amount;
        $loan->per_installment        = $per_installment;
        $loan->installment_interval   = $plan->installment_interval;
        $loan->delay_value            = $plan->delay_value;
        $loan->charge_per_installment = $charge;
        $loan->total_installment      = $plan->total_installment;
        $loan->application_form       = $applicationForm;
        $loan->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'New loan request';
        $adminNotification->click_url = urlPath('admin.loan.index') . '?search=' . $loan->loan_number;
        $adminNotification->save();

        session()->forget('loan');

        $notify[] = ['success', 'Loan application submitted successfully'];
        return redirect()->route('user.loan.list')->withNotify($notify);
    }

    public function installments($loanNumber) {
        $loan         = Loan::where('loan_number', $loanNumber)->where('user_id', auth()->id())->firstOrFail();
        $installments = $loan->installments()->paginate(getPaginate());
        $pageTitle    = 'Loan Installments';
        return view($this->activeTemplate . 'user.loan.installments', compact('pageTitle', 'installments', 'loan'));
    }
}
