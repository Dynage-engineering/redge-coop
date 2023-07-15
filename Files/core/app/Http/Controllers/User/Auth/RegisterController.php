<?php

namespace App\Http\Controllers\User\Auth;

use App\Constants\Status;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use App\Models\AdminNotification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller {
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->middleware('guest');
        $this->middleware('registration.status')->except('registrationNotAllowed');
    }

    public function showRegistrationForm() {
        $pageTitle  = "Register";
        $info       = json_decode(json_encode(getIpInfo()), true);
        $mobileCode = @implode(',', $info['code']);
        $countries  = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        return view($this->activeTemplate . 'user.auth.register', compact('pageTitle', 'mobileCode', 'countries'));
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        $general            = gs();
        $passwordValidation = Password::min(6);

        if ($general->secure_password) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $agree = $general->agree ? 'required' : 'nullable';

        $countryData  = (array)json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $countryCodes = implode(',', array_keys($countryData));
        $mobileCodes  = implode(',', array_column($countryData, 'dial_code'));
        $countries    = implode(',', array_column($countryData, 'country'));

        $validate = Validator::make($data, [
            'email'        => 'required|string|email|unique:users',
            'mobile'       => 'required|regex:/^([0-9]*)$/',
            'password'     => ['required', 'confirmed', $passwordValidation],
            'username'     => 'required|unique:users|min:6',
            'captcha'      => 'sometimes|required',
            'mobile_code'  => 'required|in:' . $mobileCodes,
            'country_code' => 'required|in:' . $countryCodes,
            'country'      => 'required|in:' . $countries,
            'agree'        => $agree
        ]);

        return $validate;
    }

    public function register(Request $request) {
        $this->validator($request->all())->validate();

        $request->session()->regenerateToken();

        if (preg_match("/[^a-z0-9_]/", trim($request->username))) {
            $notify[] = ['info', 'Username can contain only small letters, numbers and underscore.'];
            $notify[] = ['error', 'No special character, space or capital letters in username.'];
            return back()->withNotify($notify)->withInput($request->all());
        }

        if (!verifyCaptcha()) {
            $notify[] = ['error', 'Invalid captcha provided'];
            return back()->withNotify($notify);
        }


        $exist = User::where('mobile', $request->mobile_code . $request->mobile)->first();

        if ($exist) {
            $notify[] = ['error', 'The mobile number already exists'];
            return back()->withNotify($notify)->withInput();
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user) ?: redirect($this->redirectPath());
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data) {
        $general = gs();
        $user    = new User();

        $user->account_number = generateAccountNumber();
        $user->email          = strtolower(trim($data['email']));
        $user->password       = Hash::make($data['password']);
        $user->username       = trim($data['username']);
        $user->country_code   = $data['country_code'];
        $user->mobile         = $data['mobile_code'] . $data['mobile'];
        $user->kv             = $general->kv ? Status::NO : Status::YES;
        $user->ev             = $general->ev ? Status::NO : Status::YES;
        $user->sv             = $general->sv ? Status::NO : Status::YES;
        $user->ts             = Status::DISABLE;
        $user->tv             = Status::VERIFIED;

        $user->address = [
            'address' => '',
            'state'   => '',
            'zip'     => '',
            'country' => isset($data['country']) ? $data['country'] : null,
            'city'    => ''
        ];

        $referBy = session('reference');

        if ($referBy && $general->modules->referral_system) {
            $referrer = User::where('username', $referBy)->first();

            if ($referrer) {
                $user->ref_by = $referrer->id;
                $user->referral_commission_count = $general->referral_commission_count;
            }
        }

        $user->save();

        $adminNotification            = new AdminNotification();
        $adminNotification->user_id   = $user->id;
        $adminNotification->title     = 'New member registered';
        $adminNotification->click_url = urlPath('admin.users.detail', $user->id);
        $adminNotification->save();

        //Login Log Create
        $ip        = getRealIP();
        $exist     = UserLogin::where('user_ip', $ip)->first();
        $userLogin = new UserLogin();

        //Check exist or not
        if ($exist) {
            $userLogin->longitude    = $exist->longitude;
            $userLogin->latitude     = $exist->latitude;
            $userLogin->city         = $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country      = $exist->country;
        } else {
            $info                    = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude    = @implode(',', $info['long']);
            $userLogin->latitude     = @implode(',', $info['lat']);
            $userLogin->city         = @implode(',', $info['city']);
            $userLogin->country_code = @implode(',', $info['code']);
            $userLogin->country      = @implode(',', $info['country']);
        }

        $userAgent          = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip = $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os      = @$userAgent['os_platform'];
        $userLogin->save();


        return $user;
    }

    public function registered() {
        return to_route('user.home');
    }
}
