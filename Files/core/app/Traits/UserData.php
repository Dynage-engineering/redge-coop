<?php

namespace App\Traits;

use App\Models\Deposit;
use App\Models\Dps;
use App\Models\Fdr;
use App\Models\Loan;
use App\Models\Withdrawal;
use App\Models\Transaction;

trait UserData
{

    public function dashboardData($id = null)
    {
        $userId = $id ?? $this->id;

        $data['total_deposit']  = Deposit::where('user_id', $userId)->where('status', 1)->sum('amount');
        $data['total_fdr']      = Fdr::where('user_id', $userId)->count();
        $data['total_withdraw'] = Withdrawal::approved()->where('user_id', $userId)->sum('amount');
        $data['total_loan']     = Loan::approved()->where('user_id', $userId)->count();
        $data['total_dps']      = Dps::where('user_id', $userId)->count();
        $data['total_trx']      = Transaction::where('user_id', $userId)->count();

        $data['credits'] = Transaction::where('user_id', $userId)->where('trx_type', '+')->latest()->limit(5)->get();
        $data['debits']  = Transaction::where('user_id', $userId)->where('trx_type', '-')->latest()->limit(5)->get();

        return $data;
    }

    protected static function depositData()
    {
        $deposits  = auth()->user()->deposits();
        if (request()->search) {
            $deposits = $deposits->where('trx', request()->search);
        }
        $deposits = $deposits->with(['gateway', 'branch:id,name'])->orderBy('id', 'desc')->paginate(getPaginate());
        return $deposits;
    }

    protected static function withdrawData()
    {
        $withdraws = auth()->user()->withdrawals();
        if (request()->search) {
            $withdraws = $withdraws->where('trx', request()->search);
        }
        $withdraws = $withdraws->with('method', 'branch:id,name')->orderBy('id', 'desc')->paginate(getPaginate());
        return $withdraws;
    }

    protected static function transactionData()
    {
        $transactions = auth()->user()->transactions();
        if (request()->search) {
            $transactions = $transactions->where('trx', request()->search);
        }
        if (request()->type) {
            $transactions = $transactions->where('trx_type', request()->type);
        }
        if (request()->remark) {
            $transactions = $transactions->where('remark', request()->remark);
        }
        $transactions = $transactions->orderBy('id', 'desc')->paginate(getPaginate());
        return $transactions;
    }

    protected static function fdrData()
    {
        $query = auth()->user()->fdr();
        $query = $query->with('plan:id,name')->orderBy('id', 'DESC')->paginate(getPaginate());
        return $query;
    }
}
