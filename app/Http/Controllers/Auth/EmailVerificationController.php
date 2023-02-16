<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\VerifiesEmails;

 

class EmailVerificationController extends Controller
{
    use VerifiesEmails, RedirectsUsers;


    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                        ? redirect($this->redirectPath())
                        : view('auth.verify', [
                            'pageTitle' => __('Account Verification')
                        ]);
    }
    public function update(Request $request)
        {
            return $request->user()->hasVerifiedEmail()
                            ? redirect($this->redirectPath())
                            : view('auth.email-update', [
                                'pageTitle' => __('Add Email Verification')
                            ]);
        }

    public function postupdate(Request $request)
    {
        
        $input = $request->all();
        $this->validate($request, [
             'email' => 'required|email|max:255',
        ]);
        //$authUserId = auth()->user();
        
        $user = auth()->user();
        $user->email = $input['email'];
        $output=$user->save();

        // E-mail address was updated, user has to reconfirm
        if ($output) {
            //die("here..");
            $request->user()->sendEmailVerificationNotification();
            return redirect()->route('verification.notice')->withFlashInfo('Verify email');
            
        }
        //die("Out..");
        
        
        //die("here..");
        // return $request->user()->hasVerifiedEmail()
        //                 ? redirect($this->redirectPath())
        //                 : view('auth.verify', [
        //                     'pageTitle' => __('Account Verification')
        //                 ]);
    }
}
