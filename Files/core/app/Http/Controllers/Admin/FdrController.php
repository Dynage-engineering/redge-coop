<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CronController;
use App\Models\Fdr;

class FdrController extends Controller {
    public function index() {
        $this->pageTitle = 'All FDR (Fixed Deposit Receipt)';
        return $this->fdrData();
    }

    public function runningFdr() {
        $this->pageTitle = 'Running FDR (Fixed Deposit Receipt)';
        return $this->fdrData('running');
    }

    public function closedFdr() {
        $this->pageTitle = 'Closed FDR (Fixed Deposit Receipt)';
        return $this->fdrData('closed');
    }

    public function dueInstallment() {
        $this->pageTitle = 'Due Installment FDR (Fixed Deposit Receipt)';
        return $this->fdrData('due');
    }

    protected function fdrData($scope = null) {
        $query = Fdr::orderBy('id', 'DESC');
        if ($scope) {
            $query->$scope();
        }

        $pageTitle = $this->pageTitle;
        $data      = $query->searchAble(['fdr_number', 'user:username', 'plan:name'])->with('user', 'plan')->paginate(getPaginate());
        return view('admin.fdr.index', compact('pageTitle', 'data'));
    }

    public function installments($id) {
        $fdr          = Fdr::with('installments')->findOrFail($id);
        $installments = $fdr->installments()->paginate(getPaginate());
        $pageTitle    = "FDR Installments";
        return view('admin.fdr.installments', compact('pageTitle', 'installments', 'fdr'));
    }

    public function payDue($id) {
        $fdr = Fdr::findOrFail($id);
        $dueInstallment = $fdr->dueInstallment();

        if ($dueInstallment <= 0) {
            $notify[] = ['error', 'No due installment found for this FDR'];
            return back()->withNotify($notify);
        }

        for ($i = 0; $i < $dueInstallment; $i++) {
            CronController::payFdrInstallment($fdr);
        }

        $notify[] = ['success', 'Installment paid successfully'];
        return back()->withNotify($notify);
    }
}
