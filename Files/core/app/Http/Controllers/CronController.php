<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\Installment;
use App\Models\Transaction;
use App\Models\Dps;
use App\Models\Fdr;
use App\Models\Loan;

class CronController extends Controller {

    public function dps() {
        $general                = gs();
        $general->last_dps_cron = now();
        $general->save();

        $installments = Installment::where('installmentable_type', Dps::class)
            ->whereDate('installment_date', '<=', today())
            ->whereNull('given_at')
            ->whereHas('installmentable', function ($q) {
                return $q->where('status', Status::DPS_RUNNING);
            })
            ->with('installmentable')
            ->get();

        foreach ($installments as $installment) {
            $dps              = $installment->installmentable;
            $amount           = $dps->per_installment;
            $user             = $dps->user;

            $shortCodes = $dps->shortCodes();

            if ($user->balance < $amount) {
                $lastNotification = $dps->due_notification_sent ?? now()->subHours(10);

                if ($lastNotification->diffInHours(now()) >= 10) { // Notify user after 10 hours from the previous one.
                    $shortCodes['installment_date'] = showDateTime($installment->installment_date, 'd M, Y');
                    notify($user, 'DPS_INSTALLMENT_DUE', $shortCodes);
                    $dps->due_notification_sent = now();
                    $dps->save();
                }
            } else {

                $delayedDays = $installment->installment_date->diffInDays(today());
                $charge      = 0;

                if ($delayedDays >= $dps->delay_value) {
                    $charge = $dps->charge_per_installment * $delayedDays;
                    $dps->delay_charge += $charge;
                }

                $dps->given_installment += 1;

                if ($dps->given_installment == $dps->total_installment) {
                    $dps->status = Status::DPS_MATURED;
                    notify($user, 'DPS_MATURED', $shortCodes);
                }

                $dps->save();

                $user->balance -= $amount;
                $user->save();

                $installment->given_at = now();
                $installment->delay_charge = $charge;
                $installment->save();

                $transaction               = new Transaction();
                $transaction->user_id      = $user->id;
                $transaction->amount       = $amount;
                $transaction->post_balance = $user->balance;
                $transaction->charge       = 0;
                $transaction->trx_type     = '-';
                $transaction->details      = 'DPS installment paid';
                $transaction->remark       = 'dps_installment';
                $transaction->trx          = $dps->dps_number;
                $transaction->save();
            }
        }
    }

    public function loan() {
        $general                 = gs();
        $general->last_loan_cron = now();
        $general->save();

        $installments  = Installment::where('installmentable_type', Loan::class)
            ->whereDate('installment_date', '<=', today())
            ->whereNull('given_at')
            ->whereHas('installmentable', function ($q) {
                return $q->where('status', Status::LOAN_RUNNING);
            })
            ->with('installmentable')
            ->get();

        foreach ($installments as $installment) {
            $loan   = $installment->installmentable;
            $amount = $loan->per_installment;
            $user   = $loan->user;

            $shortCodes = $loan->shortCodes();

            if ($user->balance < $amount) {
                $lastNotification = $loan->due_notification_sent ?? now()->subHours(10);

                if ($lastNotification->diffInHours(now()) >= 10) {
                    // Notify user after 10 hours from the previous one.
                    $shortCodes['installment_date'] = showDateTime($installment->installment_date, 'd M, Y');
                    notify($user, 'LOAN_INSTALLMENT_DUE', $shortCodes);
                    $loan->due_notification_sent = now();
                    $loan->save();
                }
            } else {
                $delayedDays = $installment->installment_date->diffInDays(today());
                $charge      = 0;

                if ($delayedDays >= $loan->delay_value) {
                    $charge = $loan->charge_per_installment * $delayedDays;
                    $loan->delay_charge += $charge;
                }

                $loan->given_installment += 1;

                if ($loan->given_installment == $loan->total_installment) {
                    $loan->status = Status::LOAN_PAID;
                    notify($user, 'LOAN_PAID', $shortCodes);
                }

                $loan->save();

                $amount += $charge;

                $user->balance -= $amount;
                $user->save();

                $installment->given_at     = now();
                $installment->delay_charge = $charge;
                $installment->save();

                $transaction               = new Transaction();
                $transaction->user_id      = $user->id;
                $transaction->amount       = $amount;
                $transaction->post_balance = $user->balance;
                $transaction->charge       = $charge;
                $transaction->trx_type     = '-';
                $transaction->details      = 'Loan installment paid';
                $transaction->remark       = 'loan_installment';
                $transaction->trx          = $loan->loan_number;
                $transaction->save();
            }
        }
    }

    public function fdr() {
        $general                = gs();
        $now                    = now()->format('y-m-d');
        $general->last_fdr_cron = now();
        $general->save();

        $allFdr = Fdr::running()->whereDate('next_installment_date', '<=', $now)->with('user:id,username,balance')->get();

        foreach ($allFdr as $fdr) {
            self::payFdrInstallment($fdr);
        }
    }

    public static function payFdrInstallment($fdr) {
        $amount                      = $fdr->per_installment;
        $user                        = $fdr->user;
        $fdr->next_installment_date  = $fdr->next_installment_date->addDays($fdr->installment_interval);
        $fdr->profit                += $amount;
        $fdr->save();

        $user->balance += $amount;
        $user->save();

        $installment = new Installment();
        $installment->installment_date = $fdr->next_installment_date->subDays($fdr->installment_interval);
        $installment->given_at         = now();
        $fdr->installments()->save($installment);

        $transaction               = new Transaction();
        $transaction->user_id      = $user->id;
        $transaction->amount       = $amount;
        $transaction->post_balance = $user->balance;
        $transaction->charge       = 0;
        $transaction->trx_type     = '+';
        $transaction->details      = 'FDR installment received';
        $transaction->remark       = 'fdr_installment';
        $transaction->trx          = $fdr->fdr_number;
        $transaction->save();
    }
}
