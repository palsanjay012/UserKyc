<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {   
        $input = $request->all();
     
        $this->validate($request, [
            // 'email' => 'required|email',
            'mobile_no' => 'required|regex:/[0-9]{10}/|digits:10',
            'password' => 'required',
        ]);
     
        if(auth()->attempt(array('mobile_no' => $input['mobile_no'], 'password' => $input['password'])))
        {   
            // print_r(auth()->user()->type);
            // die;
            // if (auth()->user()->type == 'super-admin') {
            //     return redirect()->route('super.admin.dashboard');
            // }else if (auth()->user()->type == 'manager') {
            //     return redirect()->route('manager.dashboard');
            // }else{
            //     return redirect()->route('dashboard');
            // }
            if (auth()->user()->type == '1') {
                return redirect()->route('super.admin.dashboard');
            }else if (auth()->user()->type == '2') {
                return redirect()->route('manager.dashboard');
            }else{
                return redirect()->route('dashboard');
            }

        }else{
            return redirect()->route('login')
                ->with('error','Mobile-No. or Password Are Wrong.');
        }
          
    }
    
}
