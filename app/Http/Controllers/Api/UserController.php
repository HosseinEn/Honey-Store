<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function passwordUpdate(Request $request)
    {
        $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed|min:8|string',
        ], [
            'oldpassword.required' => 'لطفا رمزعبور کنونی را وارد نمایید!',
            'password.confirmed' => ' تایید رمزعبور مطابقت ندارد!',
        ]);
        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->oldpassword, $hashedPassword)) {
            Auth::user()->update([
                'password' => Hash::make($request->password)
            ]);
            return new JsonResponse([
                'success' => 'رمز عبور با موفقیت تغییر کرد!'
            ]);
        } else {
            throw ValidationException::withMessages([
                'oldpassword' => ['رمز عبور کنونی اشتباه است!']
            ]);
        }
    }

    public function getUser() {
        return new JsonResponse([
            'user' => Auth::user()
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users,email,' . $user->id],
            'address' => ['required', 'max:100'],
            'phone' => ['required', 'numeric'],
        ]);

        $user->update($request->all());
  
        return new JsonResponse([
            'success' => 'پروفایل شما با موفقیت ویرایش شد!'
        ]);
    } 
}
