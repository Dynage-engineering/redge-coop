<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dps;

class DpsController extends Controller {

    public function index() {
        $this->pageTitle = 'All DPS (Deposit Pension Scheme)';
        return $this->dpsData();
    }

    public function runningDps() {
        $this->pageTitle = 'Running DPS (Deposit Pension Scheme)';
        return $this->dpsData('running');
    }

    public function maturedDps() {
        $this->pageTitle = 'Matured DPS (Deposit Pension Scheme)';
        return $this->dpsData('matured');
    }

    public function closedDps() {
        $this->pageTitle = 'Closed DPS (Deposit Pension Scheme)';
        return $this->dpsData('closed');
    }

    public function dueInstallment() {

        $this->pageTitle = 'Due Installment DPS (Deposit Pension Scheme)';
        return $this->dpsData('due');
    }

    public function installments($id) {
        $dps          = Dps::with('installments')->findOrFail($id);
        $installments = $dps->installments()->paginate(getPaginate());
        $pageTitle    = "DPS Installments";
        return view('admin.dps.installments', compact('pageTitle', 'installments', 'dps'));
    }

    protected function dpsData($scope = null) {
        $query = Dps::orderBy('id', 'DESC');

        if ($scope) {
            $query->$scope();
        }

        $pageTitle = $this->pageTitle;
        $data      = $query->searchAble(['dps_number'])->with('user', 'plan')->with('nextInstallment')->withCount('dueInstallments')->paginate(getPaginate());

        return view('admin.dps.index', compact('pageTitle', 'data'));
    }
}
