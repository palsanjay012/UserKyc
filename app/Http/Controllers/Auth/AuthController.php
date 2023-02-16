<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Illuminate\Support\Str;
class AuthController extends Controller
{
        /**

     * Write code on Method

     *

     * @return response()

     */

     public function __construct()
     {
         $this->middleware('guest');
     }

/************ Comment custome post login ************
     public function index()

     {
 
         return view('auth.login');
 
     }  
/************ End Comment custome post login ************
       
 
     /**
 
      * Write code on Method
 
      *
 
      * @return response()
 
      */
 
     public function registration()
     {
         return view('auth.registration');
     }
 
       
 
     /**
 
      * Write code on Method
 
      *
 
      * @return response()
 
      */
/************ Comment custome post login ************
     public function postLogin(Request $request)
     {
         $request->validate([
             'email' => 'required',
             'password' => 'required',
         ]);

         $credentials = $request->only('email', 'password');
         if (Auth::attempt($credentials)) {
             return redirect()->intended('dashboard')
                         ->withSuccess('You have Successfully loggedin');
         }
 
         return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
     }
/************ End Comment custome post login ************/
       
 
     /**
 
      * Write code on Method
 
      *
 
      * @return response()
 
      */
 
     public function postRegistration(Request $request)
     {  
         $request->validate([
             'name' => 'required',
             'mobile_no' => 'required|regex:/[0-9]{10}/|digits:10',
         ]);
 
         $data = $request->all();
        //  print_r($data);
         $check = $this->create($data);
         session(['mobile_no' => $data['mobile_no']]);
        //  print_r($check);
        //  die("here..".$check);
         return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
     }
 
     public function otpverification(){
        return view('auth.otpverification');
     }
    
     public function postOtpverification(Request $request){
        $request->validate([
            'password' => 'required',
        ]);
        $mobile_no = $request->session()->get('mobile_no');
        //$credentials = array_merge(['mobile_no'=>$mobile_no],$request->only('password'));
        $credentials = $request->only('password') + ['mobile_no'=>$mobile_no];
       




        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully loggedin');
        }

        return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');

     }
     /**
 
      * Write code on Method
 
      *
 
      * @return response()
 
      */
 
     public function dashboard()
     {
         if(Auth::check()){
             return view('dashboard');
         }
         return redirect("login")->withSuccess('Opps! You do not have access');
 
     }
 
     
 
     /**
 
      * Write code on Method
 
      *
 
      * @return response()
 
      */
 
     public function create(array $data)
     {
       return User::create([
         'name' => $data['name'],
         'mobile_no' => $data['mobile_no'],
         'password' => Hash::make(Str::random(8))
       ]);
     }
 
     /**
      * Write code on Method
      *
      * @return response()
      */
 
     public function logout() {
         Session::flush();
         Auth::logout();
         return Redirect('login');
     }
     public function username()
        {
            return 'mobile_no';//or new email name if you changed
        }
}
