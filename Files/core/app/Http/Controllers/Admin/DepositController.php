<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Gateway\PaymentController;
use App\Models\Branch;
use App\Models\BranchStaff;
use App\Models\Deposit;
use App\Models\Gateway;
use Illuminate\Http\Request;

class DepositController extends Controller {
    public function pending() {
        $pageTitle = 'Pending Deposits';
        $branches  = Branch::active()->orderBy('name')->get();
        $deposits  = $this->depositData('pending');
        return view('admin.deposit.log', compact('pageTitle', 'deposits', 'branches'));
    }

    public function approved() {
        $pageTitle = 'Approved Deposits';
        $branches  = Branch::active()->orderBy('name')->get();
        $deposits  = $this->depositData('approved');
        return view('admin.deposit.log', compact('pageTitle', 'deposits', 'branches'));
    }

    public function successful() {
        $pageTitle = 'Successful Deposits';
        $branches  = Branch::active()->orderBy('name')->get();
        $deposits  = $this->depositData('successful');
        return view('admin.deposit.log', compact('pageTitle', 'deposits', 'branches'));
    }

    public function rejected() {
        $pageTitle = 'Rejected Deposits';
        $branches  = Branch::active()->orderBy('name')->get();
        $deposits  = $this->depositData('rejected');
        return view('admin.deposit.log', compact('pageTitle', 'deposits', 'branches'));
    }

    public function initiated() {
        $pageTitle = 'Initiated Deposits';
        $branches  = Branch::active()->orderBy('name')->get();
        $deposits  = $this->depositData('initiated');
        return view('admin.deposit.log', compact('pageTitle', 'deposits', 'branches'));
    }

    public function deposit() {
        $pageTitle   = 'Deposit History';
        $depositData = $this->depositData($scope = null, $summery = true);
        $branches    = Branch::active()->orderBy('name')->get();
        $deposits    = $depositData['data'];
        $summery     = $depositData['summery'];
        $successful  = $summery['successful'];
        $pending     = $summery['pending'];
        $rejected    = $summery['rejected'];
        $initiated   = $summery['initiated'];

        return view('admin.deposit.log', compact('pageTitle', 'deposits', 'successful', 'pending', 'rejected', 'initiated', 'branches'));
    }

    protected function depositData($scope = null, $summery = false) {
        if ($scope) {
            $deposits = Deposit::$scope()->with(['user', 'gateway', 'branch:id,name', 'branchStaff:id,name']);
        } else {
            $deposits = Deposit::with(['user', 'gateway', 'branch:id,name', 'branchStaff:id,name']);
        }

        $deposits->searchable(['trx', 'user:username'])->dateFilter();
        $request = request();

        if (request()->has('branch')) {
            $deposits->where('branch_id', $request->branch);
        }

        if (request()->has('staff')) {
            $staff = BranchStaff::findOrFail($request->staff);
            if ($staff->designation == Status::ROLE_MANAGER) {
                $deposits->whereIn('branch_id', $staff->branch_id);
            } else {
                $deposits->where('branch_staff_id', $request->staff);
            }
        }
        // Gateway
        if ($request->method) {
            $method   = Gateway::where('alias', $request->method)->firstOrFail();
            $deposits = $deposits->where('method_code', $method->code);
        }

        if (!$summery) {
            return $deposits->orderBy('id', 'desc')->paginate(getPaginate());
        } else {
            $successful = clone $deposits;
            $pending    = clone $deposits;
            $rejected   = clone $deposits;
            $initiated  = clone $deposits;

            $successfulSummery = $successful->where('status', Status::PAYMENT_SUCCESS)->sum('amount');
            $pendingSummery    = $pending->where('status', Status::PAYMENT_PENDING)->sum('amount');
            $rejectedSummery   = $rejected->where('status', Status::PAYMENT_REJECT)->sum('amount');
            $initiatedSummery  = $initiated->where('status', Status::PAYMENT_INITIATE)->sum('amount');

            return [
                'data'    => $deposits->orderBy('id', 'desc')->paginate(getPaginate()),
                'summery' => [
                    'successful' => $successfulSummery,
                    'pending'    => $pendingSummery,
                    'rejected'   => $rejectedSummery,
                    'initiated'  => $initiatedSummery,
                ],
            ];
        }
    }

    public function details($id) {
        $general   = gs();
        $deposit   = Deposit::where('id', $id)->with(['user', 'gateway'])->firstOrFail();
        $pageTitle = $deposit->user->username . ' requested ' . showAmount($deposit->amount) . ' ' . $general->cur_text;
        $details   = ($deposit->detail != null) ? json_encode($deposit->detail) : null;
        return view('admin.deposit.detail', compact('pageTitle', 'deposit', 'details'));
    }

    public function approve($id) {
        $deposit = Deposit::where('id', $id)->where('status', Status::PAYMENT_PENDING)->firstOrFail();

        PaymentController::userDataUpdate($deposit, true);

        $notify[] = ['success', 'Deposit request approved successfully'];

        return to_route('admin.deposit.pending')->withNotify($notify);
    }

    public function reject(Request $request) {
        $request->validate([
            'id'      => 'required|integer',
            'message' => 'required|string|max:255',
        ]);

        $deposit = Deposit::where('id', $request->id)->where('status', Status::PAYMENT_PENDING)->firstOrFail();

        $deposit->admin_feedback = $request->message;
        $deposit->status         = Status::PAYMENT_REJECT;
        $deposit->save();

        notify($deposit->user, 'DEPOSIT_REJECT', [
            'method_name'       => $deposit->gatewayCurrency()->name,
            'method_currency'   => $deposit->method_currency,
            'method_amount'     => showAmount($deposit->final_amo),
            'amount'            => showAmount($deposit->amount),
            'charge'            => showAmount($deposit->charge),
            'rate'              => showAmount($deposit->rate),
            'trx'               => $deposit->trx,
            'rejection_message' => $request->message,
        ]);

        $notify[] = ['success', 'Deposit request rejected successfully'];
        return to_route('admin.deposit.pending')->withNotify($notify);
    }
}
