<?php

namespace App\Http\Controllers\BranchStaff;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\ReferralCommission;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DepositController extends Controller {

    public function deposits() {
        $staff     = authStaff();
        $deposits  = Deposit::successful()->where('branch_id', session('branchId'));
        $pageTitle = 'Deposits in ' . $staff->branch()->name . ' Branch';

        if ($staff->designation == Status::ROLE_ACCOUNT_OFFICER) {
            $deposits->where('branch_staff_id', $staff->id);
        }

        $deposits = $deposits->searchable(['trx', 'user:account_number', 'branchStaff:name'])->dateFilter()->with('user', 'branchStaff:id,name')->latest()->paginate(getPaginate());
        return view('branch_staff.deposits', compact('pageTitle', 'deposits', 'staff'));
    }

    public function save(Request $request, $accountNumber) {
        $user = User::where('account_number', $accountNumber)->firstOrFail();
        $this->validation($request, $user);

        $general = gs();
        $amount  = $request->amount;
        $staff   = authStaff();
        $branch  = $staff->branch();

        $deposit                  = new Deposit();
        $deposit->user_id         = $user->id;
        $deposit->method_code     = 0;
        $deposit->method_currency = $general->cur_text;
        $deposit->amount          = $amount;
        $deposit->charge          = 0;
        $deposit->rate            = 1;
        $deposit->final_amo       = $amount;
        $deposit->btc_amo         = 0;
        $deposit->btc_wallet      = "";
        $deposit->trx             = getTrx();
        $deposit->status          = 1;
        $deposit->branch_staff_id = $staff->id;
        $deposit->branch_id       = $branch->id;
        $deposit->save();

        $user->balance += $amount;
        $user->save();

        $transaction                   = new Transaction();
        $transaction->user_id          = $user->id;
        $transaction->branch_id        = $branch->id;
        $transaction->branch_staff_id  = $staff->id;
        $transaction->amount           = $amount;
        $transaction->post_balance     = $user->balance;
        $transaction->charge           = $deposit->charge;
        $transaction->trx_type         = '+';
        $transaction->details          = 'Deposited from ' . $branch->name . ' branch';
        $transaction->trx              = $deposit->trx;
        $transaction->remark           = 'deposit';
        $transaction->save();

        ReferralCommission::levelCommission($user, $deposit->amount, $deposit->trx);

        notify($user, 'DEPOSIT_VIA_BRANCH', [
            'username'      => $user->username,
            'amount'        => showAmount($amount),
            'branch_name'   => @$branch->name,
            'charge'        => showAmount($deposit->charge),
            'trx'           => $deposit->trx,
            'post_balance'  => showAmount($user->balance),
            'site_currency' => $general->cur_text,
        ]);

        $notify[] = ['success', 'Deposited successfully'];
        return back()->withNotify($notify);
    }

    private function validation($request, $user) {
        $request->validate([
            'amount' => 'required|numeric|gt:0',
        ]);

        if (!$user->status) {
            throw ValidationException::withMessages(['error' => 'This account is currently banned']);
        }

        if (!$user->profile_complete) {
            throw ValidationException::withMessages(['error' => 'This account is not completed yet']);
        }
    }
}
