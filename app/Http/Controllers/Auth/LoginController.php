<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use LdapRecord\Laravel\Auth\ListensForLdapBindFailure;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, ListensForLdapBindFailure;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


      /**
     * Display admin login view
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        } else {
            return view('auth.login');
        }
    }

    private function getCredentials($email)
    {
        $user = User::where('username', $email)->first();

        return [
            'username' => $user->username ?? null,
            'password' => $user->password ?? null,
        ];
    }

    public function login(Request $request)
    {

        $this->validateLogin($request);

        $credentials = [
            'uid' => $request->email,
            'password' => $request->password,
            'fallback' => $this->getCredentials($request->email),
        ];

        if (Auth::attempt($credentials)) {
            return redirect(route('test'));
        } 
        
        // TODO: return err msg + display on view.
        return back()->withError('Credentials doesn\'t match.');

    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    use ListensForLdapBindFailure {
        handleLdapBindError as baseHandleLdapBindError;
    }

    protected function handleLdapBindError($message, $code = null)
    {
        if ($code == '773') {
            // The users password has expired. Redirect them.
            // abort(redirect('/password-reset'));
        }

        $this->baseHandleLdapBindError($message, $code);
    }

}
