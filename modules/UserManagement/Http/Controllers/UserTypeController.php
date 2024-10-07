<?php

namespace Modules\UserManagement\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Modules\UserManagement\Http\Requests\UserTypeRequest;
use Modules\UserManagement\Entities\UserType;

class UserTypeController extends Controller
{

    public function index()
    {
        return view('usermanagement::user-type.index',[
            'userTypes' => UserType::get(),
        ]);
    }

    public function store(UserTypeRequest $request)
    {
        $userType = new UserType();
        $userType->fill($request->all());
        $userType->save();
        Toastr::success('User Type added successfully :)','Success');
        return redirect()->route('user-types.index');
    }

    public function update(UserTypeRequest $request, $uuid)
    {
        $userType = UserType::where('uuid' , $uuid)->firstOrFail();
        $userType->fill($request->all());
        $userType->save();
        Toastr::success('User Type updated successfully :)','Success');
        return redirect()->route('user-types.index');
    }

    public function destroy($uuid)
    {
       UserType::where('uuid' , $uuid)->delete();
       Toastr::success('User Type deleted successfully :)','Success');
       return response()->json(['success' => 'success']);
    }
}
