<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        $userId = Auth::user()->id;
        $user = User::where('id',$userId)->first();

        return view('profile.edit', [
            'user'=>$user,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'=>'required',
            'phone'=>'required|numeric',
        ]);

        if($validator->passes())
        {
            $user = User::find(Auth::user()->id);
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->save();

            return redirect()->back()->with('success','Profile updated successfully.');
        }else{
            return Redirect::back()->withErrors($validator);
        }
    }

    public function changePassword()
    {
        return view('profile.change-password');

    }

    public function changePasswordProcess(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'old_password'=>'required',
            'new_password'=>'required|min:5',
            'confirm_password'=>'required|same:new_password',
        ]);

        if($validator->passes())
        {
            $user = User::select('id','password')->where('id',Auth::user()->id)->first();

            if (!Hash::check($request->old_password,$user->password))
            {
                return redirect()->back()->with('error','Your old password is incorrect, please try again.');    
            }

            User::where('id',Auth::user()->id)->update(['password'=>Hash::make($request->new_password)]);

            return redirect()->back()->with('success','You have successfully change your password.');

        }else{
            return Redirect::back()->withErrors($validator);
        }

    }

    /**
     * Display the user's profile form.
     */
    // public function edit(Request $request): View
    // {
    //     return view('profile.edit', [
    //         'user' => $request->user(),
    //     ]);
    // }

    /**
     * Update the user's profile information.
     */
    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }

    /**
     * Delete the user's account.
     */
    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }
}
