<?php

namespace App\Http\Controllers;

use App\User;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Unicodeveloper\EmailValidator\EmailValidatorFacade;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tab = "profile";
        $user = auth()->user();

        return view('admin.admin-components.profile', compact('tab', 'user'));
    }

    // public function checkEmailAddressValidator($email)
    // {
    //     $exist = EmailValidator::verify($email)->isValid()[0];
    //     return response()->json(['success' => true, 'exist' => $exist]);
    // }

    public function generatingToken(Request $request)
    {
        $id = $request->get('id');
        $request->validate([
            'id' => 'required',
        ]);

        $user = User::find($id);
        $user->remember_token = Str::random(60);
        $user->save();

        return response()->json(['error' => false, 'token' => $user->remember_token], 200);
    }

    public function changeNewPassword(Request $request)
    {
        $password = $request->get('password');

        $id = $request->get('id');

        $pass = DB::table('users')->select('password')->where('id', '=', $id)->get()->toArray();
        $oldPassword = array_shift($pass)->password;

        if(!Hash::check($password, $oldPassword))
        {
            $request->validate([
                'id' => 'required',
                'password' => 'required',
                'confirmation_password' => 'required|same:password',
            ]);

            $user = User::find($id);
            $user->password = Hash::make($password);
            $user->save();

            return redirect()->back()->with(['message' => 'You Have Been Successfull Updated Your Password!']);
        } else {
            return redirect()->back()->with(['messageFail' => 'Please Put New Password Instead Old Password!']);
        }
    }

    public function editUserNameAndEmail(Request $request)
    {
        $id = $request->get('id');
        $name = $request->get('name');
        // $email = $request->get('email');

        $request->validate([
            'id' => 'required',
            'name' => 'required|min:3|max:30',
            // 'email' => 'required|email|unique:users',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $nameByNotUserId = User::where([
          ['id', '!=', $id],
          ['name', '=', $name]
        ]);

        // if($nameByNotUserId->count() != 0) {
        //     return redirect()->back()->with(['message' => 'This Email Address Has Been Used!']);
        // }

        // $emailExist = EmailValidatorFacade::verify($email)->isValid()[0];
        // if($emailExist) {
        //     $user = User::find($id);
        //     $oldName = $user->name;
        //     $oldEmail = $user->email;
        //     $user->name = $name;
        //     $user->email = $email;
        //     $user->save();
        //
        //     if($name != $oldName && $email != $oldEmail) {
        //         return redirect()->back()->with(['message' => 'You Have Succesfull Change Your Name And Email Address!']);
        //     }
        //     return redirect()->back()->with(['message' => 'You Have Successfull Change Your Email Address!']);
        // }
        // else {
        //   return redirect()->back()->with(['messageFail' => 'This Email Address Changes Is Not Valid Email Address!']);
        // }

        if($nameByNotUserId->count() == 0) {
            $user = User::find($id);
            $user->name = $name;
            $user->save();
            return redirect()->back()->with(['message' => 'Username Has Successfull change!']);
        } else {
            return redirect()->back()->with(['messageFail' => 'Username Already Exist!']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Profile $profile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile)
    {
        //
    }
}
