<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\ReferralSetting;
use Illuminate\Http\Request;

class ReferralSettingController extends Controller {
    public function index() {
        $pageTitle = 'Manage Referral';
        $levels    = ReferralSetting::all();
        return view('admin.referral.setting', compact('pageTitle', 'levels'));
    }

    public function save(Request $request) {
        $request->validate([
            'commission'            => 'required|array',
            'commission.*.level'    => 'required|integer|min:1',
            'commission.*.percent*' => 'required|numeric|gte:0',
        ]);

        ReferralSetting::truncate();

        ReferralSetting::insert($request->commission);

        $notify[] = ['success', 'Referral setting updated successfully'];
        return back()->withNotify($notify);
    }

    public function commissionCount(Request $request) {
        $request->validate([
            'commission_count' => 'required|integer',
        ]);

        $general = GeneralSetting::first();
        $general->referral_commission_count = $request->commission_count;
        $general->save();

        $notify[] = ['success', 'Commission count updated successfully'];
        return back()->withNotify($notify);
    }
}
