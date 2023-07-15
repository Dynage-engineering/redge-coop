<?php

namespace App\Http\Controllers\Admin;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Image;

class GeneralSettingController extends Controller {
    public function index() {
        $pageTitle = 'General Setting';
        $timezones = json_decode(file_get_contents(resource_path('views/admin/partials/timezone.json')));
        return view('admin.setting.general', compact('pageTitle', 'timezones'));
    }

    public function update(Request $request) {
        $request->validate([
            'site_name'               => 'required|string|max:40',
            'cur_text'                => 'required|string|max:40',
            'cur_sym'                 => 'required|string|max:40',
            'base_color'              => 'nullable', 'regex:/^[a-f0-9]{6}$/i',
            'secondary_color'         => 'nullable', 'regex:/^[a-f0-9]{6}$/i',
            'timezone'                => 'required',
            'account_no_prefix'       => 'nullable|string|max:40',
            'account_no_length'       => 'nullable|integer|min:12|max:100',
            'otp_time'                => 'required|integer|gt:0',
            'minimum_transfer_limit'  => 'nullable|numeric|gte:0',
            'daily_transfer_limit'    => 'nullable|numeric|gte:minimum_transfer_limit',
            'monthly_transfer_limit'  => 'nullable|numeric|gte:daily_transfer_limit',
            'fixed_transfer_charge'   => 'nullable|numeric|gte:0',
            'percent_transfer_charge' => 'nullable|numeric|gte:0',
        ]);

        $general                          = gs();
        $general->site_name               = $request->site_name;
        $general->cur_text                = $request->cur_text;
        $general->cur_sym                 = $request->cur_sym;
        $general->base_color              = $request->base_color;
        $general->secondary_color         = $request->secondary_color;
        $general->account_no_prefix       = $request->account_no_prefix;
        $general->account_no_length       = $request->account_no_length;
        $general->otp_time                = $request->otp_time;
        $general->minimum_transfer_limit  = $request->minimum_transfer_limit;
        $general->daily_transfer_limit    = $request->daily_transfer_limit;
        $general->monthly_transfer_limit  = $request->monthly_transfer_limit;
        $general->fixed_transfer_charge   = $request->fixed_transfer_charge;
        $general->percent_transfer_charge = $request->percent_transfer_charge;
        $general->save();

        $timezoneFile = config_path('timezone.php');
        $content      = '<?php $timezone = ' . $request->timezone . ' ?>';
        file_put_contents($timezoneFile, $content);
        $notify[] = ['success', 'General setting updated successfully'];

        return back()->withNotify($notify);
    }

    public function systemConfiguration() {
        $pageTitle = 'System Configuration';
        $general   = gs();
        $modules   = $general->modules;
        return view('admin.setting.configuration', compact('pageTitle', 'modules'));
    }

    public function systemConfigurationSubmit(Request $request) {
        $request->validate([
            'module'   => 'nullable|array',
            'module.*' => 'in:on',
        ]);

        $general                  = GeneralSetting::first();
        $general->kv              = $request->kv ? Status::KYC_VERIFIED : Status::KYC_UNVERIFIED;
        $general->ev              = $request->ev ? Status::VERIFIED : Status::UNVERIFIED;
        $general->sv              = $request->sv ? Status::VERIFIED : Status::UNVERIFIED;
        $general->en              = $request->en ? Status::YES : Status::NO;
        $general->sn              = $request->sn ? Status::YES : Status::NO;
        $general->pn              = $request->pn ? Status::YES : Status::NO;
        $general->force_ssl       = $request->force_ssl ? Status::YES : Status::NO;
        $general->secure_password = $request->secure_password ? Status::ENABLE : Status::DISABLE;
        $general->registration    = $request->registration ? Status::ENABLE : Status::DISABLE;
        $general->agree           = $request->agree ? Status::ENABLE : Status::DISABLE;

        //module

        $modules['deposit']            = isset($request->module['deposit']) ? Status::YES : Status::NO;
        $modules['withdraw']           = isset($request->module['withdraw']) ? Status::YES : Status::NO;
        $modules['dps']                = isset($request->module['dps']) ? Status::YES : Status::NO;
        $modules['fdr']                = isset($request->module['fdr']) ? Status::YES : Status::NO;
        $modules['loan']               = isset($request->module['loan']) ? Status::YES : Status::NO;
        $modules['own_bank']           = isset($request->module['own_bank']) ? Status::YES : Status::NO;
        $modules['other_bank']         = isset($request->module['other_bank']) ? Status::YES : Status::NO;
        $modules['otp_email']          = isset($request->module['otp_email']) ? Status::YES : Status::NO;
        $modules['otp_sms']            = isset($request->module['otp_sms']) ? Status::YES : Status::NO;
        $modules['branch_create_user'] = isset($request->module['branch_create_user']) ? Status::YES : Status::NO;
        $modules['wire_transfer']      = isset($request->module['wire_transfer']) ? Status::YES : Status::NO;
        $modules['referral_system']    = isset($request->module['referral_system']) ? Status::YES : Status::NO;

        $general->modules = $modules;
        $general->save();

        $notify[] = ['success', 'System configuration updated successfully'];
        return back()->withNotify($notify);
    }

    public function logoIcon() {
        $pageTitle = 'Logo & Favicon';
        return view('admin.setting.logo_icon', compact('pageTitle'));
    }

    public function logoIconUpdate(Request $request) {
        $request->validate([
            'logo'    => ['image', new FileTypeValidate(['jpg', 'jpeg', 'png'])],
            'favicon' => ['image', new FileTypeValidate(['png'])],
        ]);

        if ($request->hasFile('logo')) {
            try {
                $path = getFilePath('logoIcon');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                Image::make($request->logo)->save($path . '/logo.png');
            } catch (\Exception$exp) {
                $notify[] = ['error', 'Couldn\'t upload the logo'];
                return back()->withNotify($notify);
            }
        }

        if ($request->hasFile('favicon')) {
            try {
                $path = getFilePath('logoIcon');
                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }
                $size = explode('x', getFileSize('favicon'));
                Image::make($request->favicon)->resize($size[0], $size[1])->save($path . '/favicon.png');
            } catch (\Exception$exp) {
                $notify[] = ['error', 'Couldn\'t upload the favicon'];
                return back()->withNotify($notify);
            }
        }
        $notify[] = ['success', 'Logo & favicon updated successfully'];
        return back()->withNotify($notify);
    }

    public function customCss() {
        $pageTitle    = 'Custom CSS';
        $file         = activeTemplate(true) . 'css/custom.css';
        $file_content = @file_get_contents($file);
        return view('admin.setting.custom_css', compact('pageTitle', 'file_content'));
    }

    public function customCssSubmit(Request $request) {
        $file = activeTemplate(true) . 'css/custom.css';
        if (!file_exists($file)) {
            fopen($file, "w");
        }
        file_put_contents($file, $request->css);
        $notify[] = ['success', 'CSS updated successfully'];
        return back()->withNotify($notify);
    }

    public function maintenanceMode() {
        $pageTitle   = 'Maintenance Mode';
        $maintenance = Frontend::where('data_keys', 'maintenance.data')->firstOrFail();
        return view('admin.setting.maintenance', compact('pageTitle', 'maintenance'));
    }

    public function maintenanceModeSubmit(Request $request) {
        $request->validate([
            'heading'     => 'required',
            'description' => 'required',
        ]);
        $general                   = GeneralSetting::first();
        $general->maintenance_mode = $request->status ? Status::ENABLE : Status::DISABLE;
        $general->save();

        $maintenance              = Frontend::where('data_keys', 'maintenance.data')->firstOrFail();
        $maintenance->data_values = [
            'heading'     => $request->heading,
            'description' => $request->description,
        ];
        $maintenance->save();

        $notify[] = ['success', 'Maintenance mode updated successfully'];
        return back()->withNotify($notify);
    }

    public function cookie() {
        $pageTitle = 'GDPR Cookie';
        $cookie    = Frontend::where('data_keys', 'cookie.data')->firstOrFail();
        return view('admin.setting.cookie', compact('pageTitle', 'cookie'));
    }

    public function cookieSubmit(Request $request) {
        $request->validate([
            'short_desc'  => 'required|string|max:255',
            'description' => 'required',
        ]);
        $cookie              = Frontend::where('data_keys', 'cookie.data')->firstOrFail();
        $cookie->data_values = [
            'short_desc'  => $request->short_desc,
            'description' => $request->description,
            'status'      => $request->status ? Status::ENABLE : Status::DISABLE,
        ];
        $cookie->save();
        $notify[] = ['success', 'Cookie policy updated successfully'];
        return back()->withNotify($notify);
    }
}
