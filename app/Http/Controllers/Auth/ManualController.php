<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Validator, Socialite;

class ManualController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $auth;

    /**
     * Create a new authentication controller instance.
     *
     * @return void

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:20|unique:users,name',
            'email' => 'required|email|max:55|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ],[
            'required' => 'Vui lòng không để trống',
            'max' => 'Quá dài, vui lòng nhập lại',
            'min' => 'Vui lòng nhiều hơn 6 ký tự',
            'unique' => 'Đã được sử dụng',
            'confirmed' => 'Vui lòng nhập lai chính xác'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'group_id'         => 6,
        ]);
    }

    public function register_manual(Request $request)
    {
        $data = $request->all();
        $validator = $this->validator($data);
        if ($validator->fails())
        {
            $errors = $validator->errors()->all();
            return redirect()->back()->withInput()->withErrors($validator);
        }else{
            $user = $this->create($data);
            \Session::flash('has_registed', 'Đăng ký thành công!');
            return redirect('/login');
        }
    }

    public function redirectToProvider($app, Request $request) {
        if ($request->has('code')) {
            $this->handleProviderCallback($app);
            return redirect('/');
        }
        return Socialite::with($app)->redirect();
    }

    public function handleProviderCallback($app) {
        $userSocial = Socialite::with($app)->user();
        $user = User::where('email', '=', $userSocial->email)->first();
        if (is_null($user)) {
            // Create new user
            $userInfo = array(
                'name'             => $userSocial->name,
                'email'            => $userSocial->email,
                'password'         => bcrypt($userSocial->email),
                'group_id'         => 6,
                'third_party'      => $app,
                'third_party_date' => serialize($userSocial),
                'third_party_id'   => $userSocial->id,
            );

            $user = User::create($userInfo);
        }
        auth()->login($user);
    }
}
