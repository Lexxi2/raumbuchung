<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use LdapRecord\Container;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            
            return redirect()->route('dashboard.index');
        } else {
            // ddd(auth()->user());
            return view('auth.login');
        }
    }

    private function getCredentials($email)
    {
        $user = User::where('username', $email)->first();

        // ddd($user);

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
            // ddd($credentials);

            // set is_admin for Admin controlls
            // Establish a connection to the LDAP server.
            Container::setDefaultConnection('default');
            
            // Retrieve the LDAP connection.
            $connection = Container::getConnection();
            
            // Search for the user by UID.
            $user = $connection->query()
            ->where('uid', '=', $credentials['uid'])
            ->first();
            
            // ddd($user['memberof']);
            // ddd(in_array('cn=app_room-res_admin,cn=groups,cn=accounts,dc=ikhost,dc=ch', $user['memberof']));

            if( in_array('cn=app_room-res_admin,cn=groups,cn=accounts,dc=ikhost,dc=ch', $user['memberof']) ){
                $u = Auth::user();
                // ddd($u);
                $us = (User::findOrFail($u->id));
                $us->is_admin = true;
                $us->save();

                // ddd($us);
                // auth()->user()->is_admin = 1;
                // ddd(auth()->user()->is_admin);
            } else {
                $u = Auth::user();
                // ddd($u);
                $us = (User::findOrFail($u->id));
                $us->is_admin = false;
                $us->save();
                // $user = Auth::user();
                // User::findOrFail($user->id)->update(['is_admin' => false]);
            }

            return redirect(route('dashboard.index'));
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
