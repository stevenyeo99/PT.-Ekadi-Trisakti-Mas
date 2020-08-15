<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Unicodeveloper\EmailValidator\EmailValidatorFacade;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\User;
use Mail;

class ManageAdminController extends Controller
{
    public function index()
    {
        $tab = "manageAdmin";
        $listOfAdmins = User::all()->where('user_role', 0);
        // dd($listOfAdmins);
        return view('admin.admin-components.manageAdmin', compact('tab', 'listOfAdmins'));
    }

    public function checkUserNameAndEmailAjax(Request $request)
    {
        $users = User::all();
        $name = $request->get('name');
        // $email = $request->get('email');
        $existName = false;
        // $existEmail = false;
        // $emailValid = EmailValidatorFacade::verify($email)->isValid()[0];
        foreach($users as $user) {
            if($user->name == $name) {
                $existName = true;
            }
            // if($user->email == $email) {
            //     $existEmail = true;
            // }
        }
        // , "meetEmail" => $existEmail, "validMail" => $emailValid
        return response()->json(["meetName" => $existName]);

    }

    public function store(Request $request)
    {
        $name = $request->get('name');
        // $email = $request->input('email');
        $password = $request->get('password');
        $passwordEncrypt = Hash::make($password);
        DB::insert('insert into users(name, password, user_role, created_at) values(?, ?, ?, ?)', [$name, $passwordEncrypt, 0, now()]);

        return redirect()->route('manageAdmin.index')->with(['message' => 'You Have Successfull Added New Admin Acount!']);
    }

    public function deleteAdminById(Request $request) {
        $adminId = $request->get('admin_id');
        $user = User::find($adminId);
        $user->delete();
        return redirect()->route('manageAdmin.index')->with(['message' => 'You Have Successfull Deleted This Admin Account!']);
    }
}
