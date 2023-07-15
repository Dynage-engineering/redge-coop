<?php

namespace App\Http\Controllers\BranchStaff;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchStaff;
use App\Models\Deposit;
use App\Models\Transaction;
use App\Models\Withdrawal;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BranchStaffController extends Controller {

    public function dashboard() {
        if (isManager()) {
            return $this->managerDashboard();
        } else {
            return $this->accountOfficerDashboard();
        }
    }

    public function managerDashboard() {
        $staff             = authStaff();
        $branch            = Branch::find(session('branchId'));
        $pageTitle         = "Branch Manager Dashboard";
        $transactions      = Transaction::where('branch_id', $branch->id)
            ->with('user:id,account_number,firstname,lastname', 'branchStaff:id,name')
            ->latest()
            ->limit(10)
            ->get();

        $depositedAmount   = Deposit::where('branch_id', $branch->id)->whereDate('created_at', today())->sum('amount');
        $withdrawnAmount   = withdrawal::where('branch_id', $branch->id)->whereDate('created_at', today())->sum('amount');

        return view('branch_staff.dashboard.manager', compact('pageTitle', 'staff', 'branch', 'transactions', 'depositedAmount', 'withdrawnAmount'));
    }

    protected function accountOfficerDashboard() {
        $pageTitle         = "Account Officer Dashboard";
        $branch            = Branch::find(session('branchId'));
        $staff             = authStaff();
        $deposits          = Deposit::successful();
        $withdrawals       = Withdrawal::approved();
        $branchDeposits    = null;
        $branchWithdrawals = null;
        $deposits          = $deposits->where('branch_id', $branch->id)->where('branch_staff_id', $staff->id);
        $withdrawals       = $withdrawals->where('branch_id', $branch->id)->where('branch_staff_id', $staff->id);
        return view('branch_staff.dashboard.staff', compact('pageTitle', 'staff', 'branch', 'deposits', 'withdrawals', 'branchDeposits', 'branchWithdrawals'));
    }

    public function profile() {
        $pageTitle = 'Profile';
        $staff     = authStaff();
        return view('branch_staff.profile', compact('pageTitle', 'staff'));
    }

    public function staffProfile($id) {
        $pageTitle = 'Staff Profile';
        $staff     = BranchStaff::findOrFail($id);
        return view('branch_staff.profile_others', compact('pageTitle', 'staff'));
    }

    public function profileUpdate(Request $request) {

        $staff = authStaff();
        $request->validate([
            'name'    => 'required',
            'email'   => 'required|email|unique:branch_staff,email,' . $staff->id,
            'mobile'  => 'required|unique:branch_staff,mobile,' . $staff->id,
            'address' => 'required',
            'image'   => ['nullable', 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
        ]);

        if ($request->hasFile('image')) {
            try {
                $old          = $staff->image;
                $staff->image = fileUploader($request->image, getFilePath('branchStaffProfile'), getFileSize('branchStaffProfile'), $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $staff->name    = $request->name;
        $staff->email   = $request->email;
        $staff->mobile  = $request->mobile;
        $staff->address = $request->address;
        $staff->save();

        $notify[] = ['success', 'Profile updated successfully'];
        return back()->withNotify($notify);
    }

    public function password() {
        $pageTitle = 'Password Setting';
        $staff     = authStaff();
        return view('branch_staff.password', compact('pageTitle', 'staff'));
    }

    public function passwordUpdate(Request $request) {
        $this->validate($request, [
            'old_password' => 'required',
            'password'     => 'required|min:5|confirmed',
        ]);

        $staff = authStaff();

        if (!Hash::check($request->old_password, $staff->password)) {
            $notify[] = ['error', 'Password doesn\'t match!!'];
            return back()->withNotify($notify);
        }

        $staff->password = Hash::make($request->password);
        $staff->save();
        $notify[] = ['success', 'Password changed successfully.'];

        return back()->withNotify($notify);
    }

    public function downloadAttachment($fileHash) {
        return downloadAttachment($fileHash);
    }

    public function setBranch($id) {
        $branches = authStaff()->assignBranch;
        $branch   = $branches->where('id', $id)->first();
        if (!$branch) {
            $branch   = $branches->first();
        }
        session()->put('branchId', $branch->id);
        return back();
    }

    public function bannedAccount() {
        if (authStaff()->status == Status::STAFF_ACTIVE) {
            return to_route('staff.dashboard');
        }
        $pageTitle = 'Banned Staff';
        return view('branch_staff.user.banned', compact('pageTitle'));
    }

    public function transactions() {
        $branch            = Branch::find(session('branchId'));
        $transactions      = Transaction::searchable(['trx', 'user:username', 'user:account_number', 'branchStaff:name'])
            ->filter(['trx_type', 'remark'])
            ->dateFilter()
            ->where('branch_id', $branch->id);

        if (authStaff()->designation == Status::ROLE_ACCOUNT_OFFICER) {
            $transactions->where('branch_staff_id', authStaff()->id);
        }

        $transactions      = $transactions->with('user:id,account_number,firstname,lastname', 'branchStaff:id,name')
            ->latest()
            ->paginate(getPaginate());

        $pageTitle = 'Transactions of ' . $branch->name . ' Branch';
        return view('branch_staff.transactions', compact('pageTitle', 'transactions'));
    }

    public function branches() {
        if (isManager()) {
            $pageTitle = 'Banned Staff';
            $branches = authStaff()->assignBranch;
            return view('branch_staff.branches', compact('pageTitle', 'branches'));
        }
        abort(404);
    }
}
