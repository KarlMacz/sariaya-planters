<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Traits\Utilities;

use Auth;
use Hash;

use App\PhBarangay;
use App\PhMunicipality;
use App\PhProvince;
use App\User;

class AuthController extends Controller
{
    use Utilities;

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        $provinces = PhProvince::orderBy('name')->get();
        $municipalities = PhMunicipality::orderBy('name')->get();
        $barangays = PhBarangay::orderBy('name')->get();

        return view('auth.register', [
            'provinces' => $provinces,
            'municipalities' => $municipalities,
            'barangays' => $barangays
        ]);
    }

    public function postLogin(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if(!empty($user)) {
            if(Auth::attempt(['email' => $email, 'password' => $password])) {
                $this->flashPrompt('ok', 'Login successful.');

                return redirect()->route('guest.index');
            } else {
                $this->flashPrompt('error', 'Invalid e-mail address and/or password.');
            }
        } else {
            $this->flashPrompt('error', 'Account doesn\'t exist.');
        }

        return redirect()->back();
    }

    public function postLogout(Request $request)
    {
        Auth::logout();

        return redirect()->route('guest.index');
    }

    public function postRegister(Request $request)
    {
        $email = $request->input('email');
        $contact_number = $request->input('contact_number', null);
        $password = $request->input('password');
        $password_confirmation = $request->input('password_confirmation');
        $first_name = $request->input('first_name');
        $middle_name = $request->input('middle_name', null);
        $last_name = $request->input('last_name');
        $address_line = $request->input('address_line');
        $postal_code = $request->input('postal_code', null);
        $province = $request->input('province');
        $city = $request->input('city');
        $barangay = $request->input('barangay');

        $user = User::where('email', $email)->first();

        if(empty($user)) {
            if($password == $password_confirmation) {
                $user = new User;

                $user->email = $email;
                $user->password = $password;
                $user->first_name = $first_name;
                $user->middle_name = $middle_name;
                $user->last_name = $last_name;
                $user->contact_number = $contact_number;
                $user->address_line = $address_line;
                $user->barangay = $barangay;
                $user->city = $city;
                $user->province = $province;
                $user->postal_code = $postal_code;

                if($user->save()) {
                    $this->flashPrompt('error', 'Registration successful.');
                } else {
                    $this->flashPrompt('error', 'Failed to register account.');
                }
            } else {
                $this->flashPrompt('error', 'Password doesn\'t match.');
            }
        } else {
            $this->flashPrompt('error', 'Account with the same e-mail address already exist.');
        }

        return redirect()->back();
    }
}
