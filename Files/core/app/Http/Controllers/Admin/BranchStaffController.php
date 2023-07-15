<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchStaff;
use App\Models\Deposit;
use App\Models\User;
use App\Models\Withdrawal;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BranchStaffController extends Controller {

    public function index() {
        $pageTitle = "Branch Staff";
        $staffs    = BranchStaff::query();

        if (request()->has('designation')) {
            $designation = request()->designation == 'manager' ? Status::ROLE_MANAGER : Status::ROLE_ACCOUNT_OFFICER;
            $staffs = $staffs->where('designation', $designation);
        }

        if (request()->has('branch')) {
            $branch     = Branch::where('name', request()->branch)->first();
            $staffs     = $staffs->withWhereHas('assignBranch', function ($query) use ($branch) {
                $query->where('branch_id', $branch->id);
            });
        }

        $staffs   = $staffs->orderBy('id', 'desc')->with('assignBranch:id,name')->searchable(['email', 'mobile'])->paginate(getPaginate());

        $branches = Branch::active()->get();
        return view('admin.staff.index', compact('pageTitle', 'staffs', 'branches'));
    }

    public function addNew() {
        $pageTitle = "Add New Staff";
        $branches  = Branch::active()->get();
        return view('admin.staff.add', compact('pageTitle', 'branches'));
    }

    public function details($id) {
        $staff     = BranchStaff::findOrFail($id);
        $pageTitle = "$staff->name Branch Details";
        $branches  = Branch::active()->get();

        $deposits    = Deposit::successful();
        $withdrawals = Withdrawal::approved();
        $users       = User::query();

        if ($staff->designation == Status::ROLE_MANAGER) {
            $branchId    = $staff->branch_id;
            $deposits    = $deposits->whereIn('branch_id', $branchId);
            $withdrawals = $withdrawals->whereIn('branch_id', $branchId);
            $users       = $users->whereIn('branch_id', $branchId);
        } else {
            $branch      = $staff->branch();
            $branchId    = $branch->id;
            $deposits    = $deposits->where('branch_id', $branchId)->where('branch_staff_id', $staff->id);
            $withdrawals = $withdrawals->where('branch_id', $branchId)->where('branch_staff_id', $staff->id);
            $users       = $users->where('branch_id', $branchId)->where('branch_staff_id', $staff->id);
        }

        $widget['total_deposited']   = $deposits->sum('amount');
        $widget['total_withdrawals'] = $withdrawals->sum('amount');
        $widget['total_user']        = $users->count();

        return view('admin.staff.details', compact('pageTitle', 'staff', 'branches', 'widget'));
    }

    public function save(Request $request, $id = 0) {

        $this->validation($request, $id);
        if ($id) {
            $staff   = BranchStaff::findOrFail($id);
            $message = "Branch staff updated successfully";
        } else {
            $staff   = new BranchStaff();
            $message = "Branch staff added successfully";
        }

        if ($request->hasFile('resume')) {
            try {
                $old           = $staff->resume;
                $staff->resume = fileUploader($request->resume, getFilePath('branchStaff'), null, $old);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload your image'];
                return back()->withNotify($notify);
            }
        }

        $staff->name        = $request->name;
        $staff->address     = $request->address;
        $staff->email       = $request->email;
        $staff->mobile      = $request->mobile;
        $staff->designation = $request->designation;
        $staff->password    = $request->password ? Hash::make($request->password) : $staff->password;
        $staff->save();

        $staff->assignBranch()->sync($request->branch);

        if (!$id) {
            $this->sendCredentials($staff, $request->password);
        }

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    private function sendCredentials($staff, $password) {
        $staff->fullname = $staff->name;
        $staff->username = $staff->email;

        notify($staff, 'STAFF_CREDENTIALS', [
            'email'    => $staff->email,
            'password' => $password,
            'login_link' => route('staff.login')
        ], ['email'], false);
    }

    private function validation($request, $id) {
        $request->validate([
            'name'        => 'required',
            'email'       => 'required|unique:branch_staff,email,' . $id,
            'mobile'      => 'required|unique:branch_staff,mobile,' . $id,
            'password'    => !$id ? 'required|min:4' : 'nullable',
            'designation' => 'required|in:0,1',
            'address'     => 'required|string',
            'resume'      => ['nullable', new FileTypeValidate(['pdf', 'docx'])],
            'branch'      => 'required|array|min:1',
        ]);
    }

    public function changeStatus($id) {
        return BranchStaff::changeStatus($id);
    }

    public function login($id) {
        Auth::guard('branch_staff')->loginUsingId($id);
        session()->put('branchId', authStaff()->branch()->id);
        return to_route('staff.dashboard');
    }
}
