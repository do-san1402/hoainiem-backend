<?php

namespace Modules\UserManagement\Http\Controllers;

use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Modules\UserManagement\Entities\UserType;
use Modules\UserManagement\Http\DataTables\UserListDataTable;
use Modules\UserManagement\Http\Requests\PasswordChangeRequest;
use Spatie\Permission\Models\Role;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:read_user_list')->only('userList', 'index');
        $this->middleware('permission:create_user_list')->only('userCreate', 'userStore');
        $this->middleware('permission:update_user_list')->only('userEdit', 'userUpdate');
        $this->middleware('permission:delete_user_list')->only('userDelete');
        $this->middleware(['demo'])->only(['update', 'userUpdate', 'updatePassword', 'userDelete']);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('usermanagement::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('usermanagement::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('usermanagement::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('usermanagement::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        DB::beginTransaction();
        try {

            $id = Auth::user()->id;
            $profileUpdate = User::with('reporter')->findOrFail($id);
            $profileUpdate->full_name = $request->full_name;
            $profileUpdate->email = $request->email;
            $profileUpdate->contact_no = $request->contact_no;

            if ($request->hasFile('signature')) {

                $destination = public_path('storage/' . $profileUpdate->signature ?? null);

                if ($profileUpdate->signature != null && file_exists($destination)) {
                    unlink($destination);
                }

                $request_file = $request->file('signature');
                $name = time() . '.' . $request_file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('signature', $request_file, $name);
                Image::make($request_file)->save(public_path('storage/' . $path));
                $profileUpdate->signature = $path;
            }
            $profileUpdate->save();

            $updateReporter = $profileUpdate->reporter;
            if ($updateReporter) {
                $updateReporter->name = $request->full_name;
                $updateReporter->email = $request->email;
                $updateReporter->mobile = $request->contact_no;

                if ($request->hasFile('signature')) {

                    $destination = public_path('storage/' . $profileUpdate->signature ?? null);

                    if ($profileUpdate->signature != null && file_exists($destination)) {
                        unlink($destination);
                    }

                    $request_file = $request->file('signature');
                    $name = time() . '.' . $request_file->getClientOriginalExtension();
                    $path = Storage::disk('public')->putFileAs('signature', $request_file, $name);
                    Image::make($request_file)->save(public_path('storage/' . $path));
                    $profileUpdate->signature = $path;
                }
            }

            DB::commit();
            $route = route('myProfile');
            return response()->json(['message' => localize('profile_updated'), 'route' => $route]);

        } catch (\Exception $e) {
            DB::rollback();
            activity()
                ->causedBy(auth()->user()) // The user causing the activity
                ->log('An error occurred: ' . $e->getMessage());
            Toastr::error('Something went wrong :)', 'Errors');
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function profilePictureUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $profileUpdate = User::with('reporter')->findOrFail($id);
            if ($request->hasFile('profile_image')) {

                $destination = public_path('storage/' . $profileUpdate->profile_image ?? null);

                if ($profileUpdate->profile_image != null && file_exists($destination)) {
                    unlink($destination);
                }

                $request_file = $request->file('profile_image');
                $name = time() . '.' . $request_file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('users', $request_file, $name);
                Image::make($request_file)->save(public_path('storage/' . $path));
                $profileUpdate->profile_image = $path;

            }
            $profileUpdate->save();

            $updateReporter = $profileUpdate->reporter;

            if ($updateReporter) {
                $request_file = $request->file('profile_image');
                $name = time() . '.' . $request_file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('users', $request_file, $name);
                Image::make($request_file)->save(public_path('storage/' . $path));
                $profileUpdate->profile_img_name = $name;
                $profileUpdate->profile_img_location = $path;
                $updateReporter->update();
            }

            DB::commit();
            return response()->json(['message' => localize('profile_updated')]);

        } catch (\Exception $e) {
            DB::rollback();
            activity()
                ->causedBy(auth()->user()) // The user causing the activity
                ->log('An error occurred: ' . $e->getMessage());
            Toastr::error('Something went wrong :)', 'Errors');
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
    public function coverImageUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $profileUpdate = User::findOrFail($id);
            if ($request->hasFile('cover_image')) {

                $destination = public_path('storage/' . $profileUpdate->cover_image ?? null);

                if ($profileUpdate->cover_image != null && file_exists($destination)) {
                    unlink($destination);
                }

                $request_file = $request->file('cover_image');
                $name = time() . '.' . $request_file->getClientOriginalExtension();
                $path = Storage::disk('public')->putFileAs('users', $request_file, $name);
                Image::make($request_file)->save(public_path('storage/' . $path));
                $profileUpdate->cover_image = $path;
            }
            $profileUpdate->save();

            DB::commit();
            return response()->json(['message' => localize('cover_image_updated')]);

        } catch (\Exception $e) {
            DB::rollback();
            activity()
                ->causedBy(auth()->user()) // The user causing the activity
                ->log('An error occurred: ' . $e->getMessage());
            Toastr::error('Something went wrong :)', 'Errors');
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function updatePassword(PasswordChangeRequest $request)
    {
        if (Hash::check($request->current_password, Auth::user()->password)) {
            $user = User::find(Auth::id());
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => localize('password_changed_message'),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => localize('old_password_message'),
            ]);
        }
    }

    //user list
    public function userList(UserListDataTable $dataTable)
    {
        $roleList = Role::all();
        $userTypes = UserType::where('is_active', true)->get();

        return $dataTable->render('usermanagement::user-management.user-list', compact('roleList', 'userTypes'));
    }

    //store user
    public function userStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'contact_no' => 'required',
            'password' => 'required|min:6',
            'role_id' => 'required',
            'user_type_id' => 'required',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],
            [
                'full_name.required' => 'The full name field is required.',
                'email.required' => 'The email field is required.',
                'email.email' => 'The email must be a valid email address.',
                'email.unique' => 'The email has already been taken.',
                'contact_no.required' => 'The mobile field is required.',
                'user_type_id.required' => 'The User Type field is required.',
                'password.required' => 'The password field is required.',
                'password.min' => 'The password must be at least 6 characters.',
                'role_id.required' => 'The role field is required.',
                'profile_image.image' => 'The profile image must be an image.',
                'profile_image.mimes' => 'The profile image must be a file of type: jpeg, png, jpg, gif, svg.',
                'profile_image.max' => 'The profile image may not be greater than 2048 kilobytes.',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ]);
        }

        $user = new User();
        $user->user_type_id = $request->user_type_id;
        $user->is_active = $request->status;
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->contact_no = $request->contact_no;

        if ($request->hasFile('profile_image')) {
            $request_file = $request->file('profile_image');
            $name = time() . '.' . $request_file->getClientOriginalExtension();
            if (!file_exists(public_path('storage/users'))) {
                mkdir(public_path('storage/users'), 0777, true);
            }
            $path = Storage::disk('public')->putFileAs('users', $request_file, $name);
            Image::make($request_file)->save(public_path('storage/' . $path));
            $user->profile_image = $path;
        }
        $user->password = Hash::make($request->password);
        $user->save();
        $user->assignRole($request->role_id);

        return response()->json(['status' => 'success', 'message' => 'User Created Successfully']);
    }

    //edit user
    public function userEdit(User $user)
    {
        $user = User::with('userRole')->findOrFail($user->id);
        $roleList = Role::all();
        $userTypes = UserType::where('is_active', true)->get();
        return response()->view('usermanagement::user-management.user-edit', compact('user', 'roleList', 'userTypes'));
    }

    //update user
    public function userUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                'email' => 'required|email|unique:users,email,' . $request->id,
                'contact_no' => 'required',
                'user_type_id' => 'required',
                'role_id' => 'required',
                'password' => 'nullable|min:6',
                'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ], [
                'role_id.required' => 'The Role field is required.',
                'full_name.required' => 'The full name field is required.',
                'email.required' => 'The email field is required.',
                'email.email' => 'The email must be a valid email address.',
                'email.unique' => 'The email has already been taken.',
                'contact_no.required' => 'The mobile field is required.',
                'user_type_id.required' => 'The User Type field is required.',
                'password.min' => 'The password must be at least 6 characters.',
                'profile_image.image' => 'The profile image must be an image.',
                'profile_image.mimes' => 'The profile image must be a file of type: jpeg, png, jpg, gif, svg.',
                'profile_image.max' => 'The profile image may not be greater than 2048 kilobytes.',
            ]);

            if ($validator->fails()) {

                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation Error',
                    'errors' => $validator->errors(),
                ]);
            }

            $user = User::with(['userRole'])->findOrFail($request->id);
            $user->full_name = $request->full_name;
            $user->user_type_id = $request->user_type_id;
            $user->is_active = $request->status;
            $user->email = $request->email;
            $user->contact_no = $request->contact_no;

            if ($request->password != null) {
                $user->password = Hash::make($request->password);
            }

            if ($request->hasFile('profile_image')) {

                $destination = public_path('storage/' . $user->profile_image ?? null);

                if ($user->profile_image != null && file_exists($destination)) {
                    unlink($destination);
                }

                $request_file = $request->file('profile_image');
                $name = time() . '.' . $request_file->getClientOriginalExtension();
                //create folder if not exists
                if (!file_exists(public_path('storage/users'))) {
                    mkdir(public_path('storage/users'), 0777, true);
                }
                $path = Storage::disk('public')->putFileAs('users', $request_file, $name);
                Image::make($request_file)->save(public_path('storage/' . $path));
                $user->profile_image = $path;
            }

            $user->save();

            $updateEmployee = $user->employee;
            if ($updateEmployee != null) {
                $fullName = explode(' ', $request->full_name);
                $updateEmployee->first_name = $fullName[0];
                $updateEmployee->last_name = $fullName[1] ?? '';
                $updateEmployee->email = $request->email;
                $updateEmployee->phone = $request->contact_no;

                if ($request->hasFile('profile_image')) {
                    $destination = public_path('storage/employee/' . $updateEmployee->profile_img_name ?? null);

                    if ($updateEmployee->profile_img_name != null && file_exists($destination)) {
                        unlink($destination);
                    }

                    $request_file = $request->file('profile_image');
                    $filename = time() . rand(10, 1000) . '.' . $request_file->extension();
                    $path = $request_file->storeAs('employee', $filename, 'public');
                    $updateEmployee->profile_img_name = $filename;
                    $updateEmployee->profile_img_location = $path;
                }
                $updateEmployee->save();
            }

            foreach ($user->userRole as $role) {
                $user->removeRole($role->id);
            }
            $user->assignRole($request->role_id);

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'User Updated Successfully']);

        } catch (\Exception $e) {
            DB::rollback();
            activity()
                ->causedBy(auth()->user()) // The user causing the activity
                ->log('An error occurred: ' . $e->getMessage());
            Toastr::error('Something went wrong :)', 'Errors');
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    //delete user
    public function userDelete(Request $request)
    {
        $user = User::with('userRole')->findOrFail($request->id);
        foreach ($user->userRole as $role) {
            $user->removeRole($role->id);
        }

        $destination = public_path('storage/' . $user->profile_image ?? null);
        if ($user->profile_image != null && file_exists($destination)) {
            unlink($destination);
        }

        $user->delete();

        return response()->json(['status' => 'success', 'message' => 'User Deleted Successfully']);
    }

    //get user by ajax for select2 when search
    public function getUserByAjax(Request $request)
    {
        $data = User::where('full_name', 'LIKE', '%' . $request->input('term', '') . '%')->take(100)->get(['id', 'full_name as text']);
        //append one more data in first position

        $data->prepend(['id' => 0, 'text' => 'All']);
        return ['results' => $data];
    }

}
