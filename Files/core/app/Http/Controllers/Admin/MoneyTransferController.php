<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\BalanceTransfer;
use App\Models\Transaction;
use Illuminate\Http\Request;

class MoneyTransferController extends Controller {

    public function index() {
        $this->pageTitle = 'All Transfer';
        return $this->transferData();
    }

    public function pending() {
        $this->pageTitle = 'Pending Transfers';
        return $this->transferData('pending');
    }

    public function rejected() {
        $this->pageTitle = 'Rejected Transfers';
        return $this->transferData('rejected');
    }

    public function ownBank() {
        $this->pageTitle = 'Own Bank Transfers';
        return $this->transferData('ownBank');
    }

    public function otherBank() {
        $this->pageTitle = 'Other Bank Transfers';
        return $this->transferData('otherBank');
    }

    public function wireTransfer() {
        $this->pageTitle = 'Wire Transfers';
        return $this->transferData('wireTransfer');
    }

    protected function transferData($scope = null) {
        $pageTitle = $this->pageTitle;
        $query     = BalanceTransfer::searchAble(['trx', 'user:username'])->orderBy('id', 'DESC');

        if ($scope) {
            $query = $query->$scope();
        }

        $transfers = $query->with('user', 'beneficiary.beneficiaryOf', 'beneficiary.user')->paginate(getPaginate());
        return view('admin.transfers.index', compact('pageTitle', 'transfers'));
    }

    public function details($id) {
        $transfer  = BalanceTransfer::where('id', $id)->with('user', 'beneficiary.beneficiaryOf')->firstOrFail();
        $pageTitle = 'Transfer Details';
        return view('admin.transfers.details', compact('pageTitle', 'transfer'));
    }

    public function complete($id) {
        $transfer = BalanceTransfer::where('id', $id)->with('beneficiary.beneficiaryOf')->firstOrFail();

        if ($transfer->status == Status::TRANSFER_COMPLETED) {
            $notify[] = ['error', 'This transfer has already been completed'];
            return back()->withNotify($notify);
        }

        $transfer->status = Status::TRANSFER_COMPLETED;
        $transfer->save();

        if ($transfer->beneficiary_id) {
            $shortCodes = $this->bankTransferShortCodes($transfer);
            $template   = 'OTHER_BANK_TRANSFER_COMPLETE';
        } else {
            $shortCodes = $this->wireTransferShortCodes($transfer);
            $template   = 'WIRE_TRANSFER_COMPLETED';
        }

        notify($transfer->user, $template, $shortCodes);

        $notify[] = ['success', 'Transfer completed successfully'];
        return back()->withNotify($notify);
    }

    public function reject(Request $request) {

        $request->validate([
            'reject_reason' => 'required',
            'id'            => 'required',
        ]);

        $transfer = BalanceTransfer::where('id', $request->id)->with('user', 'beneficiary.beneficiaryOf')->firstOrFail();

        if ($transfer->status != Status::TRANSFER_PENDING) {
            $notify[] = ['error', 'This transfer can\'t be rejected'];
            return back()->withNotify($notify);
        }

        $transfer->status        = Status::TRANSFER_REJECTED;
        $transfer->reject_reason = $request->reject_reason;
        $transfer->save();

        $user = $transfer->user;
        $user->balance += $transfer->final_amount;
        $user->save();

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $transfer->final_amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->remark       = 'transfer_amount_refund';
        $transaction->details      = 'Transferred amount refunded';
        $transaction->trx          = $transfer->trx;
        $transaction->save();

        if ($transfer->beneficiary_id) {
            $shortCodes = $this->bankTransferShortCodes($transfer);
            $template   = 'OTHER_BANK_TRANSFER_REJECT';
        } else {
            $shortCodes = $this->wireTransferShortCodes($transfer);
            $template   = 'WIRE_TRANSFER_REJECTED';
        }

        notify($transfer->user, $template, $shortCodes);

        $notify[] = ['success', 'Transfer rejected successfully'];
        return back()->withNotify($notify);
    }

    private function bankTransferShortCodes($transfer) {
        $bank = $transfer->beneficiary->beneficiaryOf;
        return [
            "sender_account_number"    => $transfer->user->account_number,
            "sender_account_name"      => $transfer->user->username,
            "recipient_account_number" => $transfer->beneficiary->account_number,
            "recipient_account_name"   => $transfer->beneficiary->account_name,
            "sending_amount"           => showAmount($transfer->amount),
            "charge"                   => showAmount($transfer->charge),
            "final_amount"             => showAmount($transfer->final_amount),
            "bank_name"                => $bank->name,
            "reject_reason"            => $transfer->reject_reason,
        ];
    }

    private function wireTransferShortCodes($transfer) {
        $accountName   = $transfer->wireTransferAccountName();
        $accountNumber = $transfer->wireTransferAccountNumber();

        return [
            "sender_account_number"    => $transfer->user->account_number,
            "sender_account_name"      => $transfer->user->username,
            "recipient_account_number" => $accountNumber,
            "recipient_account_name"   => $accountName,
            "sending_amount"           => $transfer->amount,
            "charge"                   => $transfer->charge,
            "final_amount"             => $transfer->final_amount,
            "reject_reason"            => $transfer->reject_reason,
        ];
    }
}
