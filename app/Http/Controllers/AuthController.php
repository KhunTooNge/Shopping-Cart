<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Storage;

class AuthController extends Controller
{

    //dashboard
    public function dashboard()
    {
        if (Auth::user()->role == 'user') {
            return redirect()->route('user#home');
        } else {
            return redirect()->route('category#list');
        }
    }
    // login Page
    public function loginPage()
    {
        return view('login');
    }
    // register Page
    public function registerPage()
    {
        return view('register');
    }

    // list page
    public function adminlist()
    {

        $admin = User::when(request('keys'), function ($query) {
            $query->where('role', 'admin')
                ->where('name', 'like', '%' . request('keys') . '%')
                ->orWhere('phone', 'like', '%' . request('keys') . '%')
                ->orWhere('address', 'like', '%' . request('keys') . '%')
                ->orWhere('gender', 'like', request('keys'))->paginate(5);
        })->where('role', 'admin')->paginate(5);

        $admin->appends(request()->all());
        return view('admin.admindetail.list', compact('admin'));

    }

    // delete data admin
    public function userDelete($id)
    {
        User::where('id', $id)->delete();
        return redirect()->route('admin#list')->with(['message' => 'Successfully deleted!']);
    }
    // editPassword
    public function editPassword()
    {
        return view('admin.admindetail.password');
    }

    //changePassword
    public function updatePassword(Request $request)
    {

        $validator = $this->passwordValidation($request);
        $databasePass = User::where('id', Auth::user()->id)->first();

        if (Hash::check($request->oldPass, $databasePass->password)) {
            $newPassword = $this->realUpdateData($request);

            User::where('id', Auth::user()->id)->update($newPassword);

            Auth::logout();

            return redirect()->route('auth#loginPage');
        }

        return back()->with(['err' => 'old Password does not match try again']);

    }

    // see account
    public function accountPage()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('admin.admindetail.editProfile', compact('user'));
    }

    // edit admin Infomation
    public function editPage()
    {
        return view('admin.admindetail.changeInfo');
    }

    // update profile
    public function updateProfile(Request $request)
    {
        $this->adminValidationCheck($request);
        $updateData = $this->updateAdminInfoData($request);
        if ($request->hasFile('image')) {

            $oldData = User::where('id', Auth::user()->id)->first();
            $dbImage = $oldData->image;

            if ($dbImage != null) {
                Storage::delete('public/' . $dbImage);
            }

            $fileName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);
            $updateData['image'] = $fileName;

        }
        User::where('id', Auth::user()->id)->update($updateData);
        return redirect()->route('admin#list')->with(['message' => 'Your Data Update Success!']);
    }

    // role page
    public function role($id)
    {
        $account = User::where('id', $id)->first();
        return view('admin.admindetail.roleChange', compact('account'));
    }

    // role chagne
    public function roleChange(Request $request, $id)
    {
        $update = [
            'role' => $request->role,
        ];
        User::where('id', $id)->update($update);
        return redirect()->route('admin#list');
    }

    // real update admin info data
    private function updateAdminInfoData($request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'updated_at' => Carbon::now(),
        ];
        return $data;
    }

    // update admin infomation
    private function adminValidationCheck($request)
    {
        return Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'gender' => 'required',
        ])->validate();
    }

    // password validation check
    private function passwordValidation($request)
    {
        return Validator::make($request->all(), [
            'oldPass' => 'required|min:8',
            'newPass' => 'required|min:8',
            'confirmPass' => 'required|same:newPass',
        ])->validate();
    }

    // data for update password
    private function realUpdateData($request)
    {
        return [
            'password' => Hash::make($request->newPass),
        ];
    }
}
