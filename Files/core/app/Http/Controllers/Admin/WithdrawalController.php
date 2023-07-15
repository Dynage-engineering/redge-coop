<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchStaff;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller {
    public function pending() {
        $pageTitle   = 'Pending Withdrawals';
        $branches    = Branch::active()->orderBy('name')->get();
        $withdrawals = $this->withdrawalData('pending');
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'branches'));
    }

    public function approved() {
        $pageTitle   = 'Approved Withdrawals';
        $branches    = Branch::active()->orderBy('name')->get();
        $withdrawals = $this->withdrawalData('approved');
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'branches'));
    }

    public function rejected() {
        $pageTitle   = 'Rejected Withdrawals';
        $branches    = Branch::active()->orderBy('name')->get();
        $withdrawals = $this->withdrawalData('rejected');
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'branches'));
    }

    public function log() {
        $pageTitle      = 'Withdrawals Log';
        $withdrawalData = $this->withdrawalData($scope = null, $summery = true);
        $branches       = Branch::active()->orderBy('name')->get();
        $withdrawals    = $withdrawalData['data'];
        $summery        = $withdrawalData['summery'];
        $successful     = $summery['successful'];
        $pending        = $summery['pending'];
        $rejected       = $summery['rejected'];
        return view('admin.withdraw.withdrawals', compact('pageTitle', 'withdrawals', 'successful', 'pending', 'rejected', 'branches'));
    }

    protected function withdrawalData($scope = null, $summery = false) {
        if ($scope) {
            $withdrawals = Withdrawal::$scope();
        } else {
            $withdrawals = Withdrawal::where('status', '!=', Status::PAYMENT_INITIATE);
        }

        $request     = request();
        $withdrawals = $withdrawals->searchable(['trx', 'user:username'])->dateFilter();

        if (request()->has('branch')) {
            $withdrawals->where('branch_id', $request->branch);
        }

        if (request()->has('staff')) {
            $staff = BranchStaff::findOrFail($request->staff);
            if ($staff->designation == Status::ROLE_MANAGER) {
                $withdrawals->whereIn('branch_id', $staff->branch_id);
            } else {
                $withdrawals->where('branch_staff_id', $request->staff);
            }
        }

        if ($request->method) {
            $withdrawals = $withdrawals->where('method_id', $request->method);
        }

        if (!$summery) {
            return $withdrawals->with(['user', 'method', 'branch', 'branchStaff'])->orderBy('id', 'desc')->paginate(getPaginate());
        } else {

            $successful = clone $withdrawals;
            $pending    = clone $withdrawals;
            $rejected   = clone $withdrawals;

            $successfulSummery = $successful->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
            $pendingSummery    = $pending->where('status', Status::PAYMENT_PENDING)->sum('amount');
            $rejectedSummery   = $rejected->where('status', Status::PAYMENT_REJECT)->sum('amount');

            return [
                'data'    => $withdrawals->with(['user', 'method', 'branch', 'branchStaff'])->orderBy('id', 'desc')->paginate(getPaginate()),
                'summery' => [
                    'successful' => $successfulSummery,
                    'pending'    => $pendingSummery,
                    'rejected'   => $rejectedSummery,
                ],
            ];
        }
    }

    public function details($id) {
        $general    = gs();
        $withdrawal = Withdrawal::where('id', $id)->where('status', '!=', Status::PAYMENT_INITIATE)->with(['user', 'method'])->firstOrFail();
        $pageTitle  = $withdrawal->user->username . ' Withdraw Requested ' . showAmount($withdrawal->amount) . ' ' . $general->cur_text;
        $details    = $withdrawal->withdraw_information ? json_encode($withdrawal->withdraw_information) : null;

        return view('admin.withdraw.detail', compact('pageTitle', 'withdrawal', 'details'));
    }

    public function approve(Request $request) {
        $request->validate(['id' => 'required|integer']);
        $withdraw                 = Withdrawal::where('id', $request->id)->where('status', Status::PAYMENT_PENDING)->with('user')->firstOrFail();
        $withdraw->status         = Status::PAYMENT_SUCCESS;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        notify($withdraw->user, 'WITHDRAW_APPROVE', [
            'method_name'     => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount'   => showAmount($withdraw->final_amount),
            'amount'          => showAmount($withdraw->amount),
            'charge'          => showAmount($withdraw->charge),
            'rate'            => showAmount($withdraw->rate),
            'trx'             => $withdraw->trx,
            'admin_details'   => $request->details,
        ]);

        $notify[] = ['success', 'Withdrawal approved successfully'];
        return to_route('admin.withdraw.pending')->withNotify($notify);
    }

    public function reject(Request $request) {
        $general = gs();
        $request->validate(['id' => 'required|integer']);
        $withdraw = Withdrawal::where('id', $request->id)->where('status', Status::PAYMENT_PENDING)->with('user')->firstOrFail();

        $withdraw->status         = Status::PAYMENT_REJECT;
        $withdraw->admin_feedback = $request->details;
        $withdraw->save();

        $user = $withdraw->user;
        $user->balance += $withdraw->amount;
        $user->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $withdraw->user_id;
        $transaction->amount       = $withdraw->amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->remark       = 'withdraw_reject';
        $transaction->details      = showAmount($withdraw->amount) . ' ' . $general->cur_text . ' Refunded from withdrawal rejection';
        $transaction->trx          = $withdraw->trx;
        $transaction->save();

        notify($user, 'WITHDRAW_REJECT', [
            'method_name'     => $withdraw->method->name,
            'method_currency' => $withdraw->currency,
            'method_amount'   => showAmount($withdraw->final_amount),
            'amount'          => showAmount($withdraw->amount),
            'charge'          => showAmount($withdraw->charge),
            'rate'            => showAmount($withdraw->rate),
            'trx'             => $withdraw->trx,
            'post_balance'    => showAmount($user->balance),
            'admin_details'   => $request->details,
        ]);

        $notify[] = ['success', 'Withdrawal rejected successfully'];
        return to_route('admin.withdraw.pending')->withNotify($notify);
    }
}
