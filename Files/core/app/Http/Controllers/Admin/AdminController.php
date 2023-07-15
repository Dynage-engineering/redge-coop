<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Lib\CurlRequest;
use App\Models\AdminNotification;
use App\Models\Beneficiary;
use App\Models\Deposit;
use App\Models\Dps;
use App\Models\Fdr;
use App\Models\Loan;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Withdrawal;
use App\Rules\FileTypeValidate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller {

    private function widgetData() {
        $widget['total_users']             = User::count();
        $widget['verified_users']          = User::active()->count();
        $widget['email_unverified_users']  = User::emailUnverified()->count();
        $widget['mobile_unverified_users'] = User::mobileUnverified()->count();

        $widget['total_pending_loan'] = Loan::pending()->count();
        $widget['total_due_loan']     = Loan::due()->count();
        $widget['total_running_loan'] = Loan::running()->count();
        $widget['total_paid_loan']    = Loan::paid()->count();

        $widget['total_dps']         = Dps::count();
        $widget['total_running_dps'] = Dps::running()->count();
        $widget['total_matured_dps'] = Dps::matured()->count();
        $widget['total_due_dps']     = Dps::due()->count();

        $widget['total_fdr']         = Fdr::count();
        $widget['total_running_fdr'] = Fdr::running()->count();
        $widget['total_closed_fdr']  = Fdr::closed()->count();
        $widget['total_due_fdr']     = Fdr::due()->count();

        $widget['total_deposit_pending']  = Deposit::pending()->count();
        $widget['total_deposit_rejected'] = Deposit::rejected()->count();

        $widget['total_withdraw_pending']  = Withdrawal::pending()->count();
        $widget['total_withdraw_rejected'] = Withdrawal::rejected()->count();

        return $widget;
    }

    private function piChartData() {
        // user Browsing, Country, Operating Log
        $userLoginData = UserLogin::where('created_at', '>=', now()->subDay(30))->get(['browser', 'os', 'country']);

        $piChart['user_browser_counter'] = $userLoginData->groupBy('browser')->map(function ($item, $key) {
            return collect($item)->count();
        });

        $piChart['user_os_counter'] = $userLoginData->groupBy('os')->map(function ($item, $key) {
            return collect($item)->count();
        });

        $piChart['user_country_counter'] = $userLoginData->groupBy('country')->map(function ($item, $key) {
            return collect($item)->count();
        })->sort()->reverse()->take(5);

        return $piChart;
    }

    public function dashboard() {

        $pageTitle = 'Dashboard';
        $widget    = $this->widgetData();
        $chartData = $this->piChartData();
        $plusTrx   = Transaction::plus()->sumAmount()->lastDays()->latest()->groupBy('date')->get();
        $minusTrx  = Transaction::minus()->sumAmount()->lastDays()->latest()->groupBy('date')->get();

        $trxReport['date'] = collect([]);

        $plusTrx->map(function ($trxData) use ($trxReport) {
            $trxReport['date']->push($trxData->date);
        });

        $minusTrx->map(function ($trxData) use ($trxReport) {
            $trxReport['date']->push($trxData->date);
        });

        $trxReport['date'] = dateSorting($trxReport['date']->unique()->toArray());

        $depositsMonth = Deposit::lastDays(365)->successful()->sumAmount()->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")->latest()->groupBy('months')->get();

        $withdrawalMonth = Withdrawal::lastDays(365)->approved()->sumAmount()->selectRaw("DATE_FORMAT(created_at,'%M-%Y') as months")->latest()->groupBy('months')->get();

        // Monthly Deposit & Withdraw Report Graph
        $report['months']                = collect([]);
        $report['deposit_month_amount']  = collect([]);
        $report['withdraw_month_amount'] = collect([]);

        $depositsMonth->map(function ($depositData) use ($report) {
            $report['months']->push($depositData->months);
            $report['deposit_month_amount']->push(getAmount($depositData->depositAmount));
        });

        $withdrawalMonth->map(function ($withdrawData) use ($report) {
            if (!in_array($withdrawData->months, $report['months']->toArray())) {
                $report['months']->push($withdrawData->months);
            }
            $report['withdraw_month_amount']->push(getAmount($withdrawData->withdrawAmount));
        });

        $months = $this->makeMonthArray($report['months']);

        foreach ($months as $month) {
            $chartData['deposits'][]    = getAmount(@$depositsMonth->where('months', $month)->first()->depositAmount);
            $chartData['withdrawals'][] = getAmount(@$withdrawalMonth->where('months', $month)->first()->withdrawAmount);
        }

        foreach ($trxReport['date'] as $trxDate) {
            $chartData['plus_trx'][]  = $plusTrx->where('date', $trxDate)->first()->amount ?? 0;
            $chartData['minus_trx'][] = $minusTrx->where('date', $trxDate)->first()->amount ?? 0;
        }

        $chartData['trx_dates'] = $trxReport['date'];
        return view('admin.dashboard', compact('pageTitle', 'widget', 'chartData', 'report', 'months'));
    }

    public function profile() {
        $pageTitle = 'Profile';
        $admin     = auth('admin')->user();
        return view('admin.profile', compact('pageTitle', 'admin'));
    }

    public function profileUpdate(Request $request) {
        $this->validate($request, [
            'name'  => 'required',
            'email' => 'required|email',
            'image' => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);
        $user = auth('admin')->user();

        if ($request->hasFile('image')) {
            try {
                $old         = $user->image;
                $user->image = fileUploader($request->image, getFilePath('adminProfile'), getFileSize('adminProfile'), $old);
            } catch (\Exception$exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return to_route('admin.profile')->withNotify($notify);
    }

    public function password() {
        $pageTitle = 'Password Setting';
        $admin     = auth('admin')->user();
        return view('admin.password', compact('pageTitle', 'admin'));
    }

    public function passwordUpdate(Request $request) {
        $this->validate($request, [
            'old_password' => 'required',
            'password'     => 'required|min:5|confirmed',
        ]);

        $user = auth('admin')->user();
        if (!Hash::check($request->old_password, $user->password)) {
            $notify[] = ['error', 'Password doesn\'t match!!'];
            return back()->withNotify($notify);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        $notify[] = ['success', 'Password changed successfully.'];
        return to_route('admin.password')->withNotify($notify);
    }

    public function notifications() {
        $notifications = AdminNotification::orderBy('id', 'desc')->with('user')->paginate(getPaginate());
        $pageTitle     = 'Notifications';
        return view('admin.notifications', compact('pageTitle', 'notifications'));
    }

    public function notificationRead($id) {
        $notification          = AdminNotification::findOrFail($id);
        $notification->is_read = Status::YES;
        $notification->save();
        $url = $notification->click_url;
        if ($url == '#') {
            $url = url()->previous();
        }
        return redirect($url);
    }

    public function requestReport() {
        $pageTitle            = 'Your Listed Report & Request';
        $arr['app_name']      = systemDetails()['name'];
        $arr['app_url']       = env('APP_URL');
        $arr['purchase_code'] = env('PURCHASE_CODE');
        $url                  = "https://license.viserlab.com/issue/get?" . http_build_query($arr);
        $response             = CurlRequest::curlContent($url);
        $response             = json_decode($response);
        if ($response->status == 'error') {
            return to_route('admin.dashboard')->withErrors($response->message);
        }
        $reports = $response->message[0];
        return view('admin.reports', compact('reports', 'pageTitle'));
    }

    public function reportSubmit(Request $request) {
        $request->validate([
            'type'    => 'required|in:bug,feature',
            'message' => 'required',
        ]);
        $url = 'https://license.viserlab.com/issue/add';

        $arr['app_name']      = systemDetails()['name'];
        $arr['app_url']       = env('APP_URL');
        $arr['purchase_code'] = env('PURCHASE_CODE');
        $arr['req_type']      = $request->type;
        $arr['message']       = $request->message;
        $response             = CurlRequest::curlPostContent($url, $arr);
        $response             = json_decode($response);
        if ($response->status == 'error') {
            return back()->withErrors($response->message);
        }
        $notify[] = ['success', $response->message];
        return back()->withNotify($notify);
    }

    public function readAll() {
        AdminNotification::where('is_read', Status::NO)->update([
            'is_read' => Status::YES,
        ]);
        $notify[] = ['success', 'Notifications read successfully'];
        return back()->withNotify($notify);
    }

    public function downloadAttachment($fileHash) {
        return downloadAttachment($fileHash);
    }

    public function beneficiaryDetails($id) {
        $beneficiary = Beneficiary::where('id', $id)->first();

        if (!$beneficiary) {
            return response()->json([
                'success' => false,
                'message' => "Beneficiary not found",
            ]);
        }
        $data = @$beneficiary->details;

        $html = view('components.view-form-data', compact('data'))->render();

        return response()->json([
            'success' => true,
            'html'    => $html,
        ]);
    }

    private function makeMonthArray($months) {
        for ($i = 0; $i < $months->count(); ++$i) {
            $monthVal = Carbon::parse($months[$i]);
            if (isset($months[$i + 1])) {
                $monthValNext = Carbon::parse($months[$i + 1]);
                if ($monthValNext < $monthVal) {
                    $temp           = $months[$i];
                    $months[$i]     = Carbon::parse($months[$i + 1])->format('F-Y');
                    $months[$i + 1] = Carbon::parse($temp)->format('F-Y');
                } else {
                    $months[$i] = Carbon::parse($months[$i])->format('F-Y');
                }
            }
        }
        return $months;
    }
}
