<?php

namespace App\Modules\System\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
    protected $passwordLength = '6';
    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    public $redirectTo = '/system';
    public function redirectPath()
    {
        return '/system';
    }
    public function redirectTo()
    {
        return '/system';
    }
    protected function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }
    public function broker()
    {
        return Password::broker('staff');
    }
}
